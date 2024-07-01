<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Pagination\Paginator;

class AkunController extends Controller
{
  
    public function index(Request $request)
    {
        $query = $request->input('query');
        $users = User::all();

    
        // Mengatur jumlah item yang ditampilkan per halaman
        $perPage = 1000;
    
        // Mendapatkan nomor halaman dari query string jika ada, atau default ke 1
        $currentPage = Paginator::resolveCurrentPage('page');
    
        // Membuat instance Paginator untuk koleksi berita
        $pagination = new Paginator($users->slice(($currentPage - 1) * $perPage, $perPage), $users->count());
        $pagination->withPath(route('users.index'));
    
        return view('Akun.index', [
            'users' => $pagination,
            'query' => $query,
        ]);
    }
    
    public function create()
    {
        return view('Akun.create');
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
            'no_telfon' => 'required',
            'role' => 'required|in:Admin,Pegawai',
        ]);
    
        $existingUser = User::where('email', $validatedData['email'])->first();
    
        if ($existingUser) {
            // Email sudah ada dalam database, berikan respons atau lakukan tindakan lainnya
            // ...
        } else {
            // Mengenkripsi password
            $encryptedPassword = bcrypt($validatedData['password']);
    
            // Menyimpan data ke database
            $user = new User;
            $user->email = $validatedData['email'];
            $user->password = $encryptedPassword;
            $user->name = $validatedData['name'];
            $user->role = $validatedData['role'];
            $user->save();
    
            // Lanjutkan dengan tindakan lainnya atau respon yang sesuai
            // ...
        }
    
    
        return redirect()->route('users.index');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $proyeks = Proyek::all(); // Mendapatkan semua proyek dari database
        return view('Akun.edit', compact('user', 'proyeks'));
    }
    
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string',
            'no_telfon' => 'required|string|max:20',
            'proyeks' => 'required|array',
            'proyeks.*' => 'exists:proyeks,id', // Pastikan proyek valid
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Update data user
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->no_telfon = $request->input('no_telfon');
        $user->save();

        // Update relasi proyek
        $user->proyeks()->sync($request->input('proyeks', []));

        // Redirect dengan pesan sukses
        return redirect()->route('akun.index')->with('success', 'User updated successfully');
    }
    
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();
    
        return redirect()->route('users.index');
    }
    
}
