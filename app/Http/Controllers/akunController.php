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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:Master,Manajer,Admin,Pengawas',
            'no_telfon' => 'required|string|max:15',
            'proyeks' => 'nullable|array',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->no_telfon = $request->no_telfon;

        if ($request->role !== 'Master') {
            $user->proyeks()->sync($request->proyeks ?? []);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Akun berhasil diperbarui.');
    }
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();
    
        return redirect()->route('users.index');
    }
    
}
