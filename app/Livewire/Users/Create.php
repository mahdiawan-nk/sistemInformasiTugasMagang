<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.app')]
class Create extends Component
{
    public $name;
    public $email;
    public $phone_number;
    public $asal_perguruan_tinggi;
    public $jenis_kelamin;
    public $status = 'Aktif';
    public $role = 'Mahasiswa';
    public $password;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone_number' => 'nullable|string|max:20',
        'asal_perguruan_tinggi' => 'nullable|string|max:255',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'status' => 'required|in:Aktif,Tidak Aktif',
        'role' => 'required|in:Admin,Mahasiswa',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
        'status.required' => 'Status wajib dipilih.',
        'status.in' => 'Status harus Aktif atau Tidak Aktif.',
        'role.required' => 'Role wajib dipilih.',
        'role.in' => 'Role harus Admin atau Mahasiswa.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
    ];
    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'asal_perguruan_tinggi' => $this->asal_perguruan_tinggi,
            'jenis_kelamin' => $this->jenis_kelamin,
            'status' => $this->status,
            'role' => $this->role,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('success', 'User berhasil ditambahkan');

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}