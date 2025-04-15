<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Famille;
use App\Models\User;
use App\Services\Cart;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Pos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // #[WithPagination('articles')]
    #[Url(as: 'famille')]
    public $famille_id = null;
    public $client_id;
    #[Url()]
    public $search = '';
    public $typeDiscount = 'fixed';
    public $discount = 0;

 

    public function addToPanier($article_id)
    {
        $article = Article::find($article_id);
        $cart = new Cart();
        $cart->add($article->id, $article->designation, $article->prix_ht);
        session()->flash('success', 'Article ajouté au panier !');
    }

    public function clear()
    {
        $cart = new Cart();
        $cart->clear();
        $this->reset('discount');
        session()->flash('success', 'Panier vidé !');
    }

    public function filterByFamille($famille_id = null)
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
        $familles = Famille::all();
        $clients = User::where('is_client', true)->get();
        $articles = Article::when($this->famille_id, function ($query) {
            $query->where('famille_id', $this->famille_id);
        })
            ->where('designation', 'like', '%' . $this->search . '%')
            ->paginate(5);
        $cart = new Cart();
        $cartItems = $cart->getCart();
        $total = $cart->total();
        if ($this->typeDiscount == 'percentage') {
            $totalWithDiscout = $cart->total() - ($cart->total() * (floatval($this->discount) / 100));
        } else {
            $totalWithDiscout = (number_format($cart->total() - floatval($this->discount), 2, '.', ''));
        }
        return view('livewire.pos', compact('familles', 'clients', 'articles', 'cartItems', 'total', 'totalWithDiscout'));
    }
}
