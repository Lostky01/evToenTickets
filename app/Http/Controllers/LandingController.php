<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LandingController extends Controller
{
    public function loginShow()
    {
        return view('main.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nis_email' => 'required',
            'password' => 'required',
        ]);

        // Cari user berdasarkan NIS atau Email
        $user = Users::where('nis', $request->nis_email)
            ->orWhere('email', $request->nis_email)
            ->first();

        if (!$user) {
            return back()->withErrors(['nis_email' => 'User tidak ditemukan']);
        }

        // Cek password pake Hash::check()
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        // Kalau user adalah external, cek OTP
        if ($user->user_type == 'External' && !$user->is_verified) {
            session(['email' => $user->email]); // Simpan email ke session buat validasi OTP nanti
            return redirect()->route('otp-form')->with('message', 'Verifikasi OTP dulu sebelum login.');
        }

        // Gunakan Auth::login() untuk login biar Laravel handle session
        Auth::login($user);

        return redirect()->route('home');
    }

    public function loginAdminShow()
    {
        return view('main.login_admin');
    }
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = AdminUser::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan']);
        }

        // Cek password tanpa hash
        if ($request->password !== $user->password) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        // Login manual tanpa hash
        Auth::guard('admin')->login($user);

        /* dd($user); */

        return redirect()->route('index');
    }

    public function registerAdmin(Request $request)
    {
        $lastAdmin = AdminUser::orderByRaw("CAST(SUBSTRING(id, 7) AS UNSIGNED) DESC")->first();
        $nextId = $lastAdmin ? 'admin-' . ((int) substr($lastAdmin->id, 6) + 1) : 'admin-1';

        $admin = new AdminUser();
        $admin->id = $nextId;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();

        return response()->json(['message' => 'Admin berhasil dibuat', 'id' => $nextId]);
    }

    public function registerShow()
    {
        return view('main.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = new Users();
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password')); // Hash password
        $user->user_type = 'External';
        $user->save();

        // Generate OTP (4 digit angka random)
        $otp = mt_rand(1000, 9999);

        // Simpan OTP di sesi
        session(['otp' => $otp, 'email' => $request->email]);

        // Kirim OTP pake Laravel Mail
        Mail::raw("Halo,\n\nKode OTP kamu adalah: $otp\n\nJangan bagikan ke siapa pun!", function ($message) use ($request) {
            $message->to($request->email)
                ->subject("Kode OTP Anda")
                ->from('no-reply@evtoen.com', 'Evtoen');
        });

        return redirect()->route('otp-form');
    }

    public function home()
    {
        $event = Event::all();
        return view('main.home', compact('event'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login-menu');
    }

    public function verifyOtp(Request $request)
    {
        $otpInput = implode('', $request->otp); // Gabungin angka jadi satu string
        $email = session('email'); // Ambil email dari sesi

        if ($otpInput == session('otp')) {
            // Update is_verified jadi 1 di database
            Users::where('email', $email)->update(['is_verified' => 1]);

            // Hapus OTP dari sesi
            session()->forget(['otp', 'email']);

            return redirect()->route('home')->with('success', 'OTP benar! Akun berhasil diverifikasi.');
        } else {
            return back()->withErrors(['otp' => 'Kode OTP salah!']);
        }
    }

    public function detailShow($id)
    {
        $event = Event::findOrFail($id);
        return view('home', compact('event'));
    }

    public function showCheckout($id)
    {
        $event = Event::findOrFail($id);
        if (auth()->check() || auth()->guard('admin')->check()) {
            return view('main.checkout', compact('event'));
        } else {
            return route('login-menu');
        }

    }

    public function checkout(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $today = date('Y-m-d');

        if (!auth('admin')->check()) {
            if ($today < $event->event_date) {
                return redirect()->back()->withErrors(['error' => 'Event belum dimulai, tidak bisa membeli tiket']);
            }
            if ($today > $event->event_date) {
                return redirect()->back()->withErrors(['error' => 'Event sudah berakhir, tidak bisa membeli tiket']);
            }
        }

        $ticket = new Ticket();

        if (auth('admin')->check()) {
            $ticket->admin_id = auth('admin')->user()->id;
            $ticket->user_type = 'Admin';
        } elseif (auth()->check()) {
            $user = auth()->user();
            $ticket->user_id = $user->id;
            $ticket->user_type = $user->user_type;

            if ($user->user_type === 'External') {
                if ($event->quota_for_public <= 0) {
                    return redirect()->back()->withErrors(['error' => 'Kuota publik sudah habis']);
                }
                $event->quota_for_public -= 1;
                $event->save();
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Anda harus login untuk memesan tiket']);
        }

        $ticket->event_id = $event->id;
        $ticket->ticket_code = strtoupper(bin2hex(random_bytes(3)));
        $ticket->is_verified = 0;

        $qrPath = 'tickets-qr/' . $ticket->ticket_code . '.png';

        if (!File::exists(public_path('tickets-qr'))) {
            File::makeDirectory(public_path('tickets-qr'), 0755, true);
        }

        QrCode::format('png')->size(250)->generate(route('ticket-success', $ticket->ticket_code), public_path($qrPath));

        $ticket->save();

        return view('main.ticket_success', compact('event', 'ticket', 'qrPath'));
    }

    public function downloadQr(Ticket $ticket)
    {
        // Path QR Code dari database atau storage
        $qrPath = 'tickets-qr/' . $ticket->ticket_code . '.png'; // Pastikan field ini ada di DB dan simpan path file QR di situ

        if (!Storage::exists($qrPath)) {
            return back()->with('error', 'QR Code tidak ditemukan');
        }

        // Ambil nama file dari path
        $fileName = 'QR_Tiket_' . $ticket->ticket_code . '.png';

        // Download file
        return response()->download(storage_path('app/' . $qrPath), $fileName);
    }

    public function showTickets()
    {
        $user = auth()->user(); // Ambil user yang login
        $tickets = Ticket::where('user_id', $user->id)->get(); // Ambil tiket sesuai user

        return view('main.list_tiket', compact('tickets'));
    }

    public function detailMenu()
    {

    }

    private function otpGenerator()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle($characters), 0, 4);
    }

}
