<?php

namespace Entity\Shop;

use Core\ArrayCollection;

/**
 * Class Cart
 * Représente le Pnier et ses caractéristiques
 *
 * Hérite d'Entity, une classe commune à toutes les entités de l'application
 */
class Cart
{
    private $products;
    
    public function __construct()
    {
        if (isset($_SESSION['cart'])) {
            $this->products = $_SESSION['cart'];
        } else {
            $this->products = new ArrayCollection();
        }
    }
    
    public function add(Game $game)
    {
        $add = $this->products->addElement($game);
        $_SESSION['cart'] = $this->products;
        
        return $add;
    }
    
    public function getNbProducts()
    {
        return $this->products->count();
    }
    
    public function getProducts()
    {
        return $this->products;
    }
    
    public function getTotal()
    {
        $total = 0;
        
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }
        
        return $total;
    }
    
    public function emptyCart()
    {
        $this->products = null;
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }

    public function remove(Game $game)
    {
        $this->products->removeElement($game);
        $_SESSION['cart'] = $this->products;
    }
}
