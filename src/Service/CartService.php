<?php

namespace App\Service;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $repo;
    private $rs;
    

    // inject. de dépendances hors d'un controlller : constructeur

    public function __construct(ProduitRepository $repo, RequestStack $rs)
    {
        $this->repo = $repo;
        $this->rs = $rs;
    }

    public function add($id)
    {
        // nous allons récupérer / créerune session grâceà la classe RequestStack
        $session = $this->rs->getSession();

        $cart = $session->get('cart', []);
        // je récupère l'attr de session 'cart' s'il existe ou un tableau vide

        // si le produit existe déjà, j'acrémente sa quantité
        if(!empty($cart[$id]))
            $cart[$id]++;
        else
            $cart[$id] = 1;

        $session->set('cart', $cart);
        // je sauvegardel'état de mon panier à l'attr de session 'cart'
        
        // dd($session->get('cart'));
        // dd() = dump & die : afficher les infos et tuer l'execution du code

    }
}