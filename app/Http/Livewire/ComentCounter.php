<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ComentCounter extends Component
{
    public $commentCounter;

    public function __construct()
    {
        $this->commentCounter = (int) \App\Models\EditJob::exists();
    }

    public function refreshNotificationCount()
    {
        return $this->commentCounter = (int) \App\Models\EditJob::select('id','comment','created_at')->exists();
    }

    public function render()
    {
        return view('livewire.coment-counter', [
            'commentCounter' => $this->commentCounter
        ]);
    }
}
