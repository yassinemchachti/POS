<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Famille;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Pos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $familles =Famille::all();
        $clients=User::where('is_client', true)->get();
        $articles=Article::paginate(5);
        return view('livewire.pos', compact('familles','clients','articles'));
    }
}
