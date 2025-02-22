<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{
    public function index()
    {
        $event = Event::orderBy('created_at', 'desc')->get();
        if (auth('admin')->check()) { // Cek apakah admin
            return view('dashboard.index', compact('event'));
        } elseif (auth()->check()) { // Kalau user biasa
            return redirect('/home')->with('error', 'Akses ditolak!');
        } else { // Kalau belum login
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }

    }

    public function user_table()
    {
        $siswa = Users::where('user_type', 'Siswa')->get();
        if (auth('admin')->check()) { // Cek apakah admin
            return view('dashboard.siswa_table', compact('siswa'));
        } elseif (auth()->check()) { // Kalau user biasa
            return redirect('/home')->with('error', 'Akses ditolak!');
        } else { // Kalau belum login
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }
    }

    public function user_external_table()
    {
        $user = Users::where('user_type', 'External')->get();
        if (auth('admin')->check()) { // Cek apakah admin
            return view('dashboard.user_external_table', compact('user'));
        } elseif (auth()->check()) { // Kalau user biasa
            return redirect('/home')->with('error', 'Akses ditolak!');
        } else { // Kalau belum login
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }
    }

    public function create()
    {
        if (auth('admin')->check()) { // Cek apakah admin
            return view('dashboard.add_event');
        } elseif (auth()->check()) { // Kalau user biasa
            return redirect('/home')->with('error', 'Akses ditolak!');
        } else { // Kalau belum login
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required',
            'event_type' => 'required',
            'event_price' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:99999',
        ]);

        $event = new Event();
        $event->event_name = $request->event_name;
        $event->event_type = $request->event_type;
        $event->event_price = $request->event_price;
        $event->quota_for_public = $request->quota;

        if ($request->hasFile('poster')) {
            $event->poster = $this->uploadImage($request->file('poster'));
        }

        $event->save();

        return redirect()->route('index')->with('Sukses');
    }

    public function edit($id)
    {
        $data = Event::findOrFail($id);
        if (auth('admin')->check()) { // Cek apakah admin
            return view('dashboard.edit_event', compact('data'));
        } elseif (auth()->check()) { // Kalau user biasa
            return redirect('/home')->with('error', 'Akses ditolak!');
        } else { // Kalau belum login
            return redirect()->route('login-admin-menu')->with('error', 'Anda Belum Login!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'event_name' => 'required',
            'event_type' => 'required',
            'event_price' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:99999',
        ]);

        $event = Event::findOrFail($id);
        $event->event_name = $request->input('event_name');
        $event->event_type = $request->input('event_type');
        $event->event_price = $request->input('event_price');
        $event->quota_for_public = $request->input('quota');

        if ($request->hasFile('poster')) {
            if ($event->poster) {
                $this->deleteImage($event->poster);
            }
            $event->poster = $this->uploadImage($request->file('poster'));
        }

        $event->save();

        return redirect()->route('index')->with('Sukses');
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

    public function ScannerShow()
    {
        return view('dashboard.qrcode_scanner');
    }

    public function scanTicket(Request $request)
    {
        if (!$request->has('ticket_code')) {
            return response()->json(['message' => 'Request tidak mengandung ticket_code'], 400);
        }

        $rawCode = $request->input('ticket_code');
        $code = basename($rawCode);

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

        // **Cek apakah tiket ini milik admin atau user biasa**
        $isAdminTicket = !is_null($ticket->admin_id);

        if (!$isAdminTicket) {
            if ($today < $event->event_date) {
                return response()->json(['message' => 'Event belum dimulai'], 400);
            }
            if ($today > $event->event_date) {
                return response()->json(['message' => 'Event sudah berakhir'], 400);
            }
        }

        // **Cek apakah tiket sudah digunakan**
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


    public function ShowTransactionsHistory() {
        $transactions = Ticket::with(['event', 'user', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();
    
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
