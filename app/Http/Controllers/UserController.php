<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //method untuk Kelola User
    public function kelolaUser()
    {
        $users = User::paginate(10); // mengambil semua data rapat dari tabel user
        return view('user.kelola_pengguna', compact('users'));
    }

    public function create()
    {
        return view('user.tambah_user');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'telephone' => 'required|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        // dd($request->all());

        // Upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('profile_images', 'public');
            // dd($fotoPath);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephone' => $request->telephone,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('kelolauser')->with('success', 'User berhasil ditambahkan.');
    }

    //method edit
    public function edit($id) {
        $user = User::findOrFail($id);
        return view('user.edit_user', compact('user'));
    }
    
    //method update
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Jika ada password baru
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }
    
        // Update data user
        $user->name = $request->name;
        $user->telephone = $request->telephone;
        $user->email = $request->email;
    
        // Cek jika ada upload foto baru
        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->store('users', 'public');
            $user->foto = $filePath;
        }
    
        $user->save();
    
        return redirect()->route('kelolauser')->with('success', 'User berhasil diperbarui');
    }
    

    //method hapus
    public function destroy($id)
{
    $user = User::findOrFail($id);
    
    // Hapus foto dari storage jika ada
    if ($user->foto) {
        Storage::disk('public')->delete($user->foto);
    }

    $user->delete();
    
    return redirect()->route('kelolauser')->with('success', 'User berhasil dihapus.');
}

//profile
public function profile()
{
    $user = Auth::user(); 

    return view('halaman_profile', compact('user'));
}

public function editProfile()
{
    $user = Auth::user();

    if (auth()->user()->role === 'admin') {
        $layout = 'partials.admin.main';
    } else {
        $layout = 'partials.user.main';
    }
    return view('user.edit_profile', compact('user', 'layout')); 
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'telephone' => 'nullable|string|max:15',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'telephone' => $request->telephone,
    ]);

    return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
}

public function show()
{
    $user = Auth::user(); 

    if (auth()->user()->role === 'admin') {
        $layout = 'partials.admin.main';
    } else {
        $layout = 'partials.user.main';
    }
    return view('user.halaman_profile', compact('user', 'layout'));
}

public function editPassword()
{
    $user = Auth::user(); 

    if (auth()->user()->role === 'admin') {
        $layout = 'partials.admin.main';
    } else {
        $layout = 'partials.user.main';
    }
    return view('user.ubah_password', compact('user', 'layout'));
}

public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    ]);

    $user = Auth::user();

    // Cek apakah password lama cocok
    if (!Hash::check($request->old_password, $user->password)) {
        return back()->withErrors(['old_password' => 'Old password is incorrect.']);
    }

    // Update password
    $user->update([
        'password' => Hash::make($request->new_password),
    ]);

    return redirect()->route('profile.show', $user->id)->with('success', 'Password successfully updated.');
}

//unutk upload foto di halaman profile
public function uploadFoto(Request $request)
{
    $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = auth()->user();

    // Simpan file
    $path = $request->file('foto')->store('profile', 'public');

    // Update user
    $user->foto = $path;
    $user->save();

    return redirect()->back()->with('success', 'Foto berhasil diupload!');
}

}

