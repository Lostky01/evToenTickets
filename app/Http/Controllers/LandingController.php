<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Transactions;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    // Step 1: Tampilkan form input email
    // Step 1: Tampilkan form email reset
    public function resetPassShow()
    {
        return view('main.email_reset');
    }

    // Step 2: Kirim OTP ke email
    public function resetPassOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = Users::where('email', $request->email)->first();

        // Generate OTP 4 digit
        $otp = rand(1000, 9999);

        // Simpan OTP di session
        session()->put('reset_email', $user->email);
        session()->put('reset_otp', $otp);

        // Kirim email OTP
        Mail::raw("Kode OTP reset password Anda adalah: $otp", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode OTP Reset Password');
        });

        // Redirect ke halaman OTP dengan email
        return view('main.otp_password')->with('email', $user->email);
    }

    // Step 3: Tampilkan halaman OTP
    public function verifyOtpShow()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.reset.show')->withErrors(['error' => 'Silakan masukkan email terlebih dahulu.']);
        }

        return view('main.otp_password', ['email' => session()->get('reset_email')]);
    }

    // Step 4: Verifikasi OTP
    public function verifyOtpReset(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|min:4',
        ]);

        $inputOtp = implode("", $request->otp);
        $sessionOtp = session()->get('reset_otp');

        if (!$sessionOtp) {
            return back()->withErrors(['otp' => 'OTP tidak ditemukan, silakan minta ulang.']);
        }

        if ($inputOtp == $sessionOtp) {
            // Set flag OTP berhasil diverifikasi
            session()->put('otp_verified', true);
            session()->put('reset_email', session()->get('reset_email'));

            return redirect()->route('password.reset.new');
        } else {
            return back()->withErrors(['otp' => 'Kode OTP salah, coba lagi.']);
        }
    }

    // Step 5: Tampilkan form reset password
    public function resetPasswordShow()
    {
        if (!session()->get('otp_verified')) {
            return redirect()->route('password.reset.show')->withErrors(['error' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        return view('main.reset_password');
    }

    // Step 6: Update Password
    public function resetPassword(Request $request)
    {
        if (!session()->get('otp_verified')) {
            return redirect()->route('password.reset.show')->withErrors(['error' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        $request->validate([
            'password' => 'required|min:6',
        ]);

        // Ambil email dari session
        $email = session()->get('reset_email');
        if (!$email) {
            return redirect()->route('password.reset.show')->withErrors(['error' => 'Session expired, ulangi proses reset password.']);
        }

        $user = Users::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.reset.show')->withErrors(['error' => 'User tidak ditemukan.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus session
        session()->forget(['reset_email', 'reset_otp', 'otp_verified']);

        return redirect()->route('login-menu')->with('success', 'Password berhasil direset! Silakan login.');
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
        return view('main.detail-event', compact('event'));
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

    public function showHistory()
    {
        if (auth('admin')->check()) {
            $transactions = Transactions::with('event')
                ->whereNotNull('admin_id')
                ->where('admin_id', auth('admin')->user()->id)
                ->latest()
                ->get();
        } elseif (auth()->check()) {
            $transactions = Transactions::with('event')
                ->whereNotNull('user_id')
                ->where('user_id', auth()->user()->id)
                ->latest()
                ->get();
        } else {
            return redirect()->route('login-menu')->withErrors(['error' => 'Anda harus login untuk melihat riwayat transaksi']);
        }

        return view('main.history', compact('transactions'));
    }

    public function checkout(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $today = date('Y-m-d');

        if (!auth('admin')->check()) {
            /* if ($today < $event->event_date) {
            abort(403, 'Event belum dimulai, tidak bisa membeli tiket');
            } */
            if ($today > $event->event_date) {
                abort(403, 'Event sudah berakhir, tidak bisa membeli tiket');
            }
        }

        // Generate transaction_number (6 karakter random: angka + huruf besar)
        $transactionNumber = strtoupper(Str::random(6));

        $transaction = new Transactions();
        $transaction->event_id = $event->id;
        $transaction->transaction_number = $transactionNumber;
        $transaction->is_confirmed = auth('admin')->check() ? 1 : 0;

        if (auth('admin')->check()) {
            $transaction->admin_id = auth('admin')->user()->id;
            $transaction->bukti_tf = null; // Admin nggak perlu upload bukti
        } elseif (auth()->check()) {
            $user = auth()->user();
            $transaction->user_id = $user->id;

            if (!$request->hasFile('bukti_tf')) {
                return redirect()->back()->withErrors(['error' => 'Bukti transfer wajib diunggah']);
            }
            /* dd('test'); */
            // Simpan file bukti tf ke public/bukti-tf/
            $buktiTf = $request->file('bukti_tf');
            $buktiName = 'bukti_' . time() . '.' . $buktiTf->getClientOriginalExtension();
            $buktiTf->move(public_path('bukti-tf'), $buktiName);

            $transaction->bukti_tf = $buktiName;
        } else {
            return redirect()->back()->withErrors(['error' => 'Anda harus login untuk memesan tiket']);
        }

        $transaction->save();

        return redirect()->route('home')->with('success', 'Transaksi berhasil!');
    }

    /* public function checkout(Request $request, $id)
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
    $ticket->is_read = 0;

    $qrPath = 'tickets-qr/' . $ticket->ticket_code . '.png';

    if (!File::exists(public_path('tickets-qr'))) {
    File::makeDirectory(public_path('tickets-qr'), 0755, true);
    }

    QrCode::format('png')->size(250)->generate(route('ticket-success', $ticket->ticket_code), public_path($qrPath));

    $ticket->save();

    return view('main.ticket_success', compact('event', 'ticket', 'qrPath'));
    } */

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
