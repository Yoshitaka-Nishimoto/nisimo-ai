<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Component;

class MemberRegistration extends Component
{
    public string $name = '';
    public string $rank = '';
    public string $rubber = '';
    public string $style = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'rank' => 'required|string|in:初級,中級,上級',
        'rubber' => 'required|string|max:255',
        'style' => 'required|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        Member::create([
            'name' => $this->name,
            'rank' => $this->rank,
            'rubber' => $this->rubber,
            'style' => $this->style,
        ]);

        session()->flash('message', '会員登録が完了しました。');

        $this->reset();
    }
    
    public function render()
    {
        return view('livewire.member-registration')
            ->layout('components.layouts.app');
    }
}
