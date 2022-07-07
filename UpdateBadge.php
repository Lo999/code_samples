<?php

namespace App\Http\Livewire;

use App\Models\Meeting\Registration;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateBadge extends Component
{
    public $registration;
    protected $rules = [
        'registration.badge_name' => 'required|string|max:100',
        'registration.badge_institution' => 'required|string|max:100',
    ];

    public function render()
    {
        return view('livewire.update-badge');
    }

    public function update()
    {
        $this->registration->save();
        $registration = Auth::user()->member->registration();
        $names = explode(' ', $this->registration->badge_name);
        $registration->update([
            'badge_institution' => $this->registration->badge_institution,
            'badge_name' => $this->registration->badge_name,
            'badge_last_name' => end($names)
        ]);
    }
}
