<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
class Edit extends Component
{
    public $userId;

    public $name;
    public $email;
    public $phone_number;
    public $asal_perguruan_tinggi;
    public $jenis_kelamin;
    public $status;
    public $role;
    public $password;

    public function mount($id)
    {
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->asal_perguruan_tinggi = $user->asal_perguruan_tinggi;
        $this->jenis_kelamin = $user->jenis_kelamin;
        $this->status = $user->status;
        $this->role = $user->role;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->userId),
            ],
            'phone_number' => 'nullable|string|max:20',
            'asal_perguruan_tinggi' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'role' => 'required|in:Admin,Mahasiswa',
            'password' => 'nullable|min:6', // 👈 optional
        ];
    }

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
        'status.required' => 'Status wajib dipilih.',
        'status.in' => 'Status harus Aktif atau Tidak Aktif.',
        'role.required' => 'Role wajib dipilih.',
        'role.in' => 'Role harus Admin atau Mahasiswa.',
    ];

    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        // dd($user);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'asal_perguruan_tinggi' => $this->asal_perguruan_tinggi,
            'jenis_kelamin' => $this->jenis_kelamin,
            'status' => $this->status,
            'role' => $this->role,
        ];

        // jika password diisi
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        session()->flash('success', 'User berhasil diupdate');

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}