<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('parkir.admin.UserManajemen', compact('users'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|in:admin,pegawai', 
        ]);
        
            $user = User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'pegawai', // default pegawai jika tidak dipilih
            ]);
            
            return redirect()->back()
                ->with('success', 'User berhasil dibuat.');
    }
    
    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable|in:admin,pegawai',
        ]);
        
            $updateData = [
                'name' => $request->name,
                'role' => $request->role ?? $user->role, // gunakan role lama jika tidak dipilih
            ];
            
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }
            
            $user->update($updateData);
            
            return redirect()->back()
                ->with('success', 'User berhasil diperbarui.');
    }

    
    public function destroy(User $user)
    {
            
            if ($user->id === Auth::id()) {
                return redirect()->back()
                    ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            }
            
            $user->delete();
            
            return redirect()->back()
                ->with('success', 'User berhasil dihapus.');
    }
}