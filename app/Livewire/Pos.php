<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Commande;
use App\Models\DetailBL;
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

    public function saveCart()
    {
        $cart = new Cart();
        $remise=$this->typeDiscount=='percentage' ? round(($cart->total() * (floatval($this->discount) / 100))) :  $this->discount;
        $commande = Commande::create([
            'user_id' => $this->client_id,
            'remise' => $remise,
            'date' => now(),
        ]);
        $cartItems = $cart->getCart();
        foreach ($cartItems as $item) {
           DetailBL::create([
                'article_id' => $item['id'],
                'commande_id' => $commande->id,
                'qnt' => $item['quantity'],
                'prix_ht' => $item['price'],
                'tva' => 20,
                'remise' => $remise,
            ]);
        }
        $cart->clear();
        $this->reset('client_id');
        $this->reset('discount');
        $this->reset('typeDiscount');
        $this->reset('famille_id');
        $this->reset('search');
        session()->flash('success', 'Commande enregistrée avec succès !');
    }

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
        $clients = User::all();
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
