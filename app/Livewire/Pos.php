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
    public $famille_id=null;
    public $client_id;
    public $search='';

    public function filterByFamille($famille_id=null)
    {
        $this->resetPage();
        $this->famille_id = $famille_id;

    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $familles =Famille::all();
        $clients=User::where('is_client', true)->get();
        $articles = Article::when($this->famille_id, function ($query) {
            $query->where('famille_id', $this->famille_id);
        })
        ->where('designation', 'like', '%' . $this->search . '%')
        ->paginate(5);
        return view('livewire.pos', compact('familles','clients','articles'));
    }
}
