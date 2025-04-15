<?php

namespace App\Services;

use App\Models\Commande;
use Illuminate\Support\Facades\Session;

class Cart
{
    protected $cartKey = 'cart';

    public function add($id, $name, $price, $quantity = 1)
    {
        $cart = Session::get($this->cartKey, []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
            ];
        }

        Session::put($this->cartKey, $cart);
    }

    public function update($id, $quantity)
    {
        $cart = Session::get($this->cartKey, []);

        if (isset($cart[$id])) {
            if ($quantity <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = $quantity;
            }
            Session::put($this->cartKey, $cart);
        }
    }

    public function remove($id)
    {
        $cart = Session::get($this->cartKey, []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put($this->cartKey, $cart);
        }
    }

    public function clear()
    {
        Session::forget($this->cartKey);
    }

    public function getCart()
    {
        return Session::get($this->cartKey, []);
    }

    public function total()
    {
        $cart = Session::get($this->cartKey, []);
        return array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);
    }


}
