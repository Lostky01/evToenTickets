<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Transactions;
use App\Models\Users;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

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

        $user = Users::where('nis', $request->nis_email)
            ->orWhere('email', $request->nis_email)
            ->first();

        if (!$user) {
            return back()->withErrors(['nis_email' => 'User tidak ditemukan']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        if ($user->user_type == 'External' && !$user->is_verified) {
            session(['email' => $user->email]); // Simpan email ke session buat validasi OTP nanti
            return redirect()->route('otp-form')->with('message', 'Verifikasi OTP dulu sebelum login.');
        }

        Auth::login($user);

        return redirect()->route('home');
    }

    public function resetPassShow()
    {
        return view('main.email_reset');
    }

    public function resetPassOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = Users::where('email', $request->email)->first();

        $otp = rand(1000, 9999);

        session()->put('reset_email', $user->email);
        session()->put('reset_otp', $otp);

        Mail::raw("Kode OTP reset password Anda adalah: $otp", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode OTP Reset Password');
        });

        return view('main.otp_password')->with('email', $user->email);
    }

    public function verifyOtpShow()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.reset.show')->withErrors(['error' => 'Silakan masukkan email terlebih dahulu.']);
        }

        return view('main.otp_password', ['email' => session()->get('reset_email')]);
    }

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

    public function resetPasswordShow()
    {
        if (!session()->get('otp_verified')) {
            return redirect()->route('password.reset.show')->withErrors(['error' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        return view('main.reset_password');
    }

    public function resetPassword(Request $request)
    {
        if (!session()->get('otp_verified')) {
            return redirect()->route('password.reset.show')->withErrors(['error' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        $request->validate([
            'password' => 'required|min:6',
        ]);

        $email = session()->get('reset_email');
        if (!$email) {
            return redirect()->route('password.reset.show')->withErrors(['error' => 'Session expired, ulangi proses reset password.']);
        }

        $user = Users::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.reset.show')->withErrors(['error' => 'User tidak ditemukan.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

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

        $user = AdminUser::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan']);
        }

        if ($request->password !== $user->password) {
            return back()->withErrors(['password' => 'Password salah']);
        }

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

        $otp = mt_rand(1000, 9999);

        session(['otp' => $otp, 'email' => $request->email]);

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

    public function ticketDetail($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('main.detail_tiket', compact('ticket'));
    }

    public function ticketPDF($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('main.pdf_ticket', compact('ticket'));
    }

    public function verifyOtp(Request $request)
    {
        $otpInput = implode('', $request->otp);
        $email = session('email');

        if ($otpInput == session('otp')) {
            Users::where('email', $email)->update(['is_verified' => 1]);

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
            if ($today > $event->event_date) {
                abort(403, 'Event sudah berakhir, tidak bisa membeli tiket');
            }
        }

        $transactionNumber = strtoupper(Str::random(6));
        $transaction = new Transactions();
        $transaction->event_id = $event->id;
        $transaction->transaction_number = $transactionNumber;
        $transaction->is_confirmed = auth('admin')->check() ? 1 : 0;

        if (auth('admin')->check()) {
            $transaction->admin_id = auth('admin')->user()->id;
            $transaction->bukti_tf = null;
        } elseif (auth()->check()) {
            $user = auth()->user();
            $transaction->user_id = $user->id;

            if (!$request->hasFile('bukti_tf')) {
                return redirect()->back()->withErrors(['error' => 'Bukti transfer wajib diunggah']);
            }

            $buktiTf = $request->file('bukti_tf');
            $buktiName = 'bukti_' . time() . '.' . $buktiTf->getClientOriginalExtension();
            $buktiTf->move(public_path('bukti-tf'), $buktiName);
            $transaction->bukti_tf = $buktiName;
        } else {
            return redirect()->back()->withErrors(['error' => 'Anda harus login untuk memesan tiket']);
        }

        $transaction->save();

        if (auth('admin')->check()) {
            app(\App\Http\Controllers\EventController::class)->ConfirmTicket($transaction->id);
        }

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

        $qrPath = 'tickets-qr/' . $ticket->ticket_code . '.png'; // Pastikan field ini ada di DB dan simpan path file QR di situ

        if (!Storage::exists($qrPath)) {
            return back()->with('error', 'QR Code tidak ditemukan');
        }

        $fileName = 'QR_Tiket_' . $ticket->ticket_code . '.png';

        return response()->download(storage_path('app/' . $qrPath), $fileName);
    }

    public function showTickets()
    {
        if (auth('admin')->check()) {
            $user = auth('admin')->user();
            $tickets = Ticket::where('admin_id', $user->id)->get();
        } else {
            $user = auth()->user();
            $tickets = Ticket::where('user_id', $user->id)->get();
        }

        return view('main.list_tiket', compact('tickets'));
    }

    public function downloadTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $html = View::make('main.pdf_ticket', compact('ticket'))->render();
        $imagePath = public_path("tickets/ticket_$ticket->ticket_code.png");

        try {
            Browsershot::html($html)
                ->setOption('format', 'png')
                ->fullPage()
                ->save($imagePath);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        // Konversi gambar ke base64
        $imageData = base64_encode(File::get($imagePath));
        $imageSrc = "data:image/png;base64," . $imageData;
        if (!file_exists($imagePath)) {
            dd("File tidak ditemukan: " . $imagePath);
        }
        $pdf = SnappyPdf::loadView('main.pdf_template', ['imagePath' => $imageSrc]);
        try {
            return $pdf->download("ticket_$$ticket->ticket_code.pdf");
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
        
        // Kirim base64 ke view PDF
        

        
    }

    /* public function detailMenu()
    {

    } */

    private function otpGenerator()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle($characters), 0, 4);
    }

}
