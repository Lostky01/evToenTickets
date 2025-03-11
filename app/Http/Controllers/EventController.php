<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Transactions;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{

    public function mainShow()
    {
        $event = Event::orderBy('created_at', 'desc')->get();
        if (auth('admin')->check()) { 
            return view('dashboard.main', compact('event'));
        } elseif (auth()->check()) { 
            return redirect()->route('home')->with('error', 'Akses ditolak!');
        } else { 
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }

    }
    public function index()
    {
        $event = Event::orderBy('created_at', 'desc')->get();
        if (auth('admin')->check()) { 
            return view('dashboard.index', compact('event'));
        } elseif (auth()->check()) { 
            return redirect('/home')->with('error', 'Akses ditolak!');
        } else { 
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }

    }

    public function user_table()
    {
        $siswa = Users::where('user_type', 'Siswa')->get();
        if (auth('admin')->check()) { 
            return view('dashboard.siswa_table', compact('siswa'));
        } elseif (auth()->check()) { 
            return redirect('/home')->with('error', 'Akses ditolak!');
        } else { 
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }
    }

    public function CreateSiswaMenu()
    {
        return view('dashboard.add_siswa');
    }

    public function createSiswa(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:users,nis',
            'name' => 'required|string|max:255',
            'password' => 'required|min:6',
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:Akuntansi,Teknik Komputer Jaringan,Rekayasa Perangkat Lunak,Teknik Elektronika Industri,Teknik Energi Terbarukan,Teknik Bisnis Sepeda Motor',
            'no_kelas' => 'required|in:1,2,3,Industri',
        ]);

        $siswa = new Users();
        $siswa->nis = $request->nis;
        $siswa->name = $request->name;
        $siswa->kelas = $request->kelas;
        $siswa->jurusan = $request->jurusan;
        $siswa->no_kelas = $request->no_kelas;
        $siswa->user_type = 'Siswa';
        $siswa->is_verified = 1;
        $siswa->password = Hash::make($request->password);

        $siswa->save();

        return redirect()->route('siswa-table')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function editSiswa($id)
    {
        $siswa = Users::findOrFail($id);
        return view('dashboard.edit_siswa',compact('siswa'));
    }

    public function updateSiswa(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|unique:users,nis,' . $id,
            'name' => 'required|string|max:255',
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:Akuntansi,Teknik Komputer Jaringan,Rekayasa Perangkat Lunak,Teknik Elektronika Industri,Teknik Energi Terbarukan,Teknik Bisnis Sepeda Motor',
            'no_kelas' => 'required|in:1,2,3,Industri',
        ]);

        $siswa = Users::findOrFail($id);
        $siswa->nis = $request->nis;
        $siswa->name = $request->name;
        $siswa->kelas = $request->kelas;
        $siswa->jurusan = $request->jurusan;
        $siswa->no_kelas = $request->no_kelas;

        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }

        $siswa->save();

        return redirect()->route('siswa-table')->with('success', 'Siswa berhasil diperbarui!');
    }

    public function deleteSiswa($id)
    {
        $siswa = Users::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa-table')->with('success', 'Siswa berhasil dihapus!');
    }

    public function user_external_table()
    {
        $user = Users::where('user_type', 'External')->get();
        if (auth('admin')->check()) { 
            return view('dashboard.user_external_table', compact('user'));
        } elseif (auth()->check()) {
            return redirect('/home')->with('error', 'Akses ditolak!');
        } else {
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }
    }

    public function create()
    {
        if (auth('admin')->check()) { 
            return view('dashboard.add_event');
        } elseif (auth()->check()) { 
            return redirect('/home')->with('error', 'Akses ditolak!');
        } else { 
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required',
            'event_type' => 'required|in:Umum,Tidak Umum',
            'event_price' => 'required|integer',
            'event_description' => 'required',
            'event_date' => 'required|date',
            'quota_for_public' => 'nullable|integer',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:99999',
            'ig_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'yt_link' => 'nullable|url',
            'tiktok_link' => 'nullable|url',
        ]);

        $event = new Event();
        $event->event_name = $request->event_name;
        $event->event_type = $request->event_type;
        $event->event_description = strip_tags($request->event_description); // Buat mencegah XSS
        $event->event_price = $request->event_price;
        $event->event_date = $request->event_date;
        $event->quota_for_public = $request->quota_for_public;
        $event->ig_link = $request->ig_link;
        $event->twitter_link = $request->twitter_link;
        $event->yt_link = $request->yt_link;
        $event->tiktok_link = $request->tiktok_link;

        if ($request->hasFile('poster')) {
            $event->poster = $this->uploadImage($request->file('poster'));
        }

        $event->save();

        return redirect()->route('index')->with('success', 'Event berhasil dibuat!');
    }

    public function edit($id)
    {
        $data = Event::findOrFail($id);
        if (auth('admin')->check()) { 
            return view('dashboard.edit_event', compact('data'));
        } elseif (auth()->check()) { 
            return redirect('/home')->with('error', 'Akses ditolak!');
        } else { 
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'event_name' => 'required',
            'event_type' => 'required',
            'event_price' => 'required|numeric',
            'event_desc' => 'nullable|string',
            'ig_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'yt_link' => 'nullable|url',
            'tiktok_link' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:99999',
        ]);

        $event = Event::findOrFail($id);
        $event->event_name = $request->event_name;
        $event->event_type = $request->event_type;
        $event->event_price = $request->event_price;
        $event->quota_for_public = $request->quota;
        $event->event_description = strip_tags($request->event_description);
        $event->ig_link = $request->ig_link;
        $event->twitter_link = $request->twitter_link;
        $event->yt_link = $request->yt_link;
        $event->tiktok_link = $request->tiktok_link;

        if ($request->hasFile('poster')) {
            if ($event->poster) {
                $this->deleteImage($event->poster);
            }
            $event->poster = $this->uploadImage($request->file('poster'));
        }

        $event->save();

        return redirect()->route('index')->with('Sukses', 'Event berhasil diperbarui!');
    }

    private function uploadImage($imageFile)
    {
        $fileName = time() . '_' . $this->generateRandomString() . '.' . $imageFile->getClientOriginalExtension();
        $imageFile->move(public_path('poster'), $fileName);
        return $fileName;
    }

    private function deleteImage($imageUrl)
    {
        if (!empty($imageUrl)) {
            $imagePath = public_path('poster/' . $imageUrl);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->poster) {
            $this->deleteImage($event->poster);
        }
        $event->delete();

        return redirect()->route('index');
    }

    public function ScannerShow()
    {
        return view('dashboard.qrcode_scanner');
    }

    public function scanTicket(Request $request)
    {
        if (!$request->has('ticket_code')) {
            return response()->json(['message' => 'Request tidak mengandung ticket_code'], 400);
        }

        $code = $request->input('ticket_code');

        \Log::info('Extracted ticket_code: ' . $code);

        $ticket = Ticket::where('ticket_code', $code)->first();

        if (!$ticket) {
            return response()->json(['message' => 'Tiket tidak ditemukan', 'ticket_code' => $code], 404);
        }

        $event = Event::find($ticket->event_id);

        if (!$event) {
            return response()->json(['message' => 'Event tidak ditemukan'], 404);
        }

        $today = date('Y-m-d');

        
        $isAdminTicket = !is_null($ticket->admin_id);

        if (!$isAdminTicket) {
            if ($today < $event->event_date) {
                return response()->json(['message' => 'Event belum dimulai'], 400);
            }
            if ($today > $event->event_date) {
                return response()->json(['message' => 'Event sudah berakhir'], 400);
            }
        }

        if ($ticket->is_verified == 1) {
            return response()->json(['message' => 'Tiket sudah digunakan'], 400);
        }

        if ($isAdminTicket) {
            $admin = AdminUser::find($ticket->admin_id);
            if (!$admin) {
                return response()->json(['message' => '❌ Data admin tidak ditemukan'], 404);
            }
            $ticket->is_verified = 1;
            $ticket->save();

            return response()->json([
                'status' => 'success',
                'message' => '✅ Tiket Admin Berhasil Divalidasi!',
                'event' => $event->name,
                'user_type' => 'Admin',
                'user_info' => ['Nama' => 'Admin SMKN 2'],
            ]);
        }

        $user = Users::find($ticket->user_id);
        if (!$user) {
            return response()->json(['message' => '❌ Data pengguna tidak ditemukan'], 404);
        }

        $userInfo = ['Nama' => $user->name];

        if ($ticket->user_type == 'Siswa') {
            $userType = 'Siswa';
            $userInfo['Kelas'] = $user->kelas . ' ' . $user->jurusan . ' ' . $user->no_kelas;
        } else {
            $userType = 'User Eksternal';
            $userInfo['Email'] = $user->email;
        }

        $ticket->is_verified = 1;
        $ticket->save();

        return response()->json([
            'status' => 'success',
            'message' => '✅ Tiket Berhasil Divalidasi!',
            'event' => $event->name,
            'user_type' => $userType,
            'user_info' => $userInfo,
        ]);
    }

    public function TicketStatusShow()
    {
        $transactions = Transactions::all();

        Transactions::where('is_read', 0)->update(['is_read' => 1]);
        return view('dashboard.status_tiket', compact('transactions'));
    }

    public function ConfirmTicket($id)
    {
        $transaction = Transactions::findOrFail($id);

        $ticket = new Ticket();
        $ticket->event_id = $transaction->event_id;
        $ticket->user_id = $transaction->user_id;
        $ticket->admin_id = $transaction->admin_id;
        $ticket->ticket_code = strtoupper(bin2hex(random_bytes(3)));
        $ticket->is_verified = 0;
        $ticket->is_read = 0;

        $qrPath = 'tickets-qr/' . $ticket->ticket_code . '.png';

        if (!File::exists(public_path('tickets-qr'))) {
            File::makeDirectory(public_path('tickets-qr'), 0755, true);
        }

        QrCode::format('png')
            ->size(500)
            ->errorCorrection('M') 
            ->margin(2)
            ->generate($ticket->ticket_code, public_path($qrPath));

        $ticket->save();

       
        $transaction->is_confirmed = 1;
        $transaction->save();

        return redirect()->back()->with('success', 'Tiket berhasil dikonfirmasi dan QR Code telah dibuat.');
    }

    public function RejectTicket($id)
    {
        $transaction = Transactions::findOrFail($id);

        
        if ($transaction->is_confirmed == 0) {
            $transaction->update(['is_confirmed' => -1]); 
            return redirect()->back()->with('success', 'Transaksi berhasil ditolak.');
        }

        return redirect()->back()->withErrors(['error' => 'Transaksi sudah dikonfirmasi, tidak bisa ditolak.']);
    }

    public function countUnreadTicket()
    {
        return Ticket::where('is_read', 0)->count();
    }

    public function countUnreadTransactions()
    {
        return Transactions::where('is_read', 0)->count();
    }

    public function ShowTransactionsHistory()
    {
        $transactions = Ticket::with(['event', 'user', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Update semua transaksi jadi terbaca
        Ticket::where('is_read', 0)->update(['is_read' => 1]);

        return view('dashboard.transactions_history', compact('transactions'));
    }

}

/* public function getName(Request $request)
{
$id = $request->id;
$sites = Sites::where('name', $id)->pluck('name', 'id');

$options = '';
foreach ($sites as $key => $item) {
$options .= '<option value="' . $key . '">' . $item . '</option>';
}

return response()->json(['msg' => 'berhasil', 'id' => $id, 'data' => $options]);
}

public function getNameEdit(Request $request)
{
$id = $request->id;
$sites = Sites::where('name', $id)->get();

$option = "";
foreach ($sites as $key => $item) {
$option .= '<option value="' . $item->id . '">' . $item->name . '</option>';
}

return response()->json(['msg' => 'berhasil', 'id' => $id, 'data' => $option]);
} */

/* public function getProject(Request $request)
{
$id = $request->id;
$project = Project::where('name', $id)->pluck('name', 'id');

$options = '';
foreach ($project as $key => $item) {
$options .= '<option value="' . $key . '">' . $item . '</option>';
}

return response()->json(['msg' => 'berhasil', 'id' => $id, 'data' => $options]);
}

public function getProjectEdit(Request $request)
{
$id = $request->id;
$project= Project::where('name', $id)->get();

$option = "";
foreach ($project as $key => $item) {
$option .= '<option value="' . $item->id . '">' . $item->name . '</option>';
}

return response()->json(['msg' => 'berhasil', 'id' => $id, 'data' => $option]);
} */
