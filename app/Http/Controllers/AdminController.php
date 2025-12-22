<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Admin;
use App\Models\Psikolog;
use App\Models\Artikel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class AdminController extends Controller
{
    private function getModel($type)
    {
        return match ($type) {
            'admin' => Admin::class,
            'psikolog' => Psikolog::class,
            default => Mahasiswa::class,
        };
    }

    // Dashboard
    public function dashboard()
    {
        return view('admin/dashboard', [
            'totalMahasiswa' => Mahasiswa::count(),
            'totalAdmin' => Admin::count(),
            'totalPsikolog' => Psikolog::count(),
            'totalArtikel' => Artikel::count(),
        ]);
    }

    // Manage Users
    public function usersIndex(Request $request)
    {
        $type = $request->query('type', 'mahasiswa');
        $search = $request->query('search', '');

        $model = $this->getModel($type);
        $query = $model::query();

        if ($search) {
            $query->where(function ($q) use ($search, $type) {
        
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
        
                if ($type === 'mahasiswa') {
                    $q->orWhere('nim', 'LIKE', "%{$search}%")
                      ->orWhere('fakultas', 'LIKE', "%{$search}%")
                      ->orWhere('prodi', 'LIKE', "%{$search}%");
                }
        
                if ($type === 'psikolog') {
                    $q->orWhere('spesialisasi', 'LIKE', "%{$search}%");
                }
        
            });
        }        

        $users = $query->orderBy('nama')->paginate(10)->withQueryString();
        return view('admin.users.index', compact('type', 'users', 'search'));
    }

    public function create($type)
    {
        return view('admin.users.create', compact('type'));
    }

    public function store(Request $request, $type)
    {
        // VALIDATION
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            // File akan disimpan di storage/app/public/psikolog
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        ];

        if ($type === 'mahasiswa') {
            $rules['nim'] = 'required|unique:mahasiswa,nim';
            $rules['fakultas'] = 'required';
            $rules['prodi'] = 'required';
            $emailTable = (new Mahasiswa)->getTable();
        } elseif ($type === 'psikolog') {
            $rules['nomor_hp'] = 'required';
            $rules['nomor_str'] = 'required';
            $rules['spesialisasi'] = 'required';
            $emailTable = (new Psikolog)->getTable();
        } else { // admin
            $emailTable = (new Admin)->getTable();
        }

        // Validasi email unik berdasarkan tabel yang sesuai
        $rules['email'] .= '|unique:' . $emailTable . ',email';

        $validated = $request->validate($rules);

        // GENERATE PASSWORD
        $newPassword = str()->random(8);
        $password = bcrypt($newPassword);

        // // HANDLE FOTO PROFIL UNTUK PSIKOLOG (MENGGUNAKAN STORAGE FACADE)
        $fotoPath = null;
        if ($type === 'psikolog' && $request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')
                ->store('psikolog', 'public');
        }
        
        // CREATE USER
        if ($type === 'mahasiswa') {
            Mahasiswa::create([
                'nama' => $validated['nama'],
                'nim' => $validated['nim'],
                'email' => $validated['email'],
                'fakultas' => $validated['fakultas'],
                'prodi' => $validated['prodi'],
                'password' => $password,
            ]);
        } elseif ($type === 'psikolog') {
            Psikolog::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'nomor_hp' => $validated['nomor_hp'],
                'nomor_str' => $validated['nomor_str'],
                'spesialisasi' => $validated['spesialisasi'],
                'foto_profil' => $fotoPath, // Gunakan nama file yang sudah disiapkan
                'password' => $password,
            ]);
        } else { // ADMIN
            Admin::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => $password,
            ]);
        }

        session()->flash('generated_password', $newPassword);
        return redirect()->route('admin.users.index', ['type' => $type])
                         ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($type, $id)
    {
        $model = $this->getModel($type);
        $user = $model::findOrFail($id);

        return view('admin.users.edit', compact('type', 'user'));
    }

    public function update(Request $request, $type, $id)
    {
        $model = $this->getModel($type);
        $user  = $model::findOrFail($id);

        $rules = [
            'nama' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        if ($type === 'mahasiswa') {
            $rules['nim'] = [
                'required',
                Rule::unique('mahasiswa', 'nim')->ignore($id, $user->getKeyName())
            ];
            $rules['fakultas'] = 'required|string|max:255';
            $rules['prodi']    = 'required|string|max:255';
        }

        if ($type === 'psikolog') {
            $rules['nomor_str']   = 'required';
            $rules['spesialisasi'] = 'required';
        }

        $request->validate($rules);

        // ⛔ email DIABAIKAN
        $data = $request->except('email');

        if ($type === 'psikolog' && $request->hasFile('foto_profil')) {

            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $data['foto_profil'] = $request->file('foto_profil')
                ->store('psikolog', 'public');
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index', ['type' => $type])
            ->with('success', 'Data berhasil diperbarui.');
    }



    public function resetPassword($type, $id)
    {
        $model = $this->getModel($type);
        $user = $model::findOrFail($id);

        $newPassword = str()->random(8);
        $user->update(['password' => bcrypt($newPassword)]);

        return response()->json([
            'status' => 'success',
            'password' => $newPassword
        ]);
    }

    public function destroy($type, $id)
    {
        $model = $this->getModel($type);
        $user = $model::findOrFail($id);

        // Hapus foto profil psikolog jika ada
        if ($type === 'psikolog' && $user->foto_profil) {
            // Storage::disk('public')->delete('psikolog/' . $user->foto_profil);
            Storage::disk('public')->delete($user->foto_profil);
        }        

        $user->delete();
        return redirect()->route('admin.users.index', ['type' => $type])
                         ->with('success', "{$user->nama} berhasil dihapus.");
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}