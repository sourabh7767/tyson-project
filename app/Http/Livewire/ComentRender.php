<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ComentRender extends Component
{
    public $comments = [];
    // protected $preserve = ['notification'];
    

    public function refreshComments()
    {
        return $this->comments = \App\Models\EditJob::select('id','comment','user_id','created_at','job_id')->orderBy('id','DESC')->get();
    }

    public function __construct()
    {
        $this->comments = $this->refreshComments();
    }

    public function render()
    {
        return view('livewire.coment-render',['comments' => $this->comments]);
    }
}
