<?php

namespace App\Livewire;

use App\Models\User; // Userモデルをインポート
use Livewire\Component;
use Illuminate\Support\Facades\Auth; // Authファサードをインポート

class MemberRegistration extends Component
{
    public $name;
    public $email;
    public $level;

    public function mount()
    {
        $user = Auth::user();
        //dump($user);
        if ($user->name) {
            $this->name = $user->name;
            dump($this->name);
        } else {
            $this->name = ''; // Lineニックネームがない場合は空文字列を設定
        }

        if ($user && $user->email) {
            $this->email = $user->email;
        } else {
            $this->email = '';
        }
    }
    
    public function render()
    {
        return view('livewire.member-registration');
    }

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'level' => 'required|string',
        ]);

        // ユーザー登録ロジック
        // 例: $user = User::create([...]);

        session()->flash('message', 'Registration successful!');
    }
}
