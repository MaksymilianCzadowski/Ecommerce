<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="app_shop")
     */
    public function shop(ProduitRepository $repo): Response
    {
        $produits = $repo->findAll();
        $user = $this->getUser()->getUserIdentifier();
        return $this->render('shop/index.html.twig', [
            'produits' => $produits,
            'username' => $user
        ]);
    }

    /**
     * @Route("/shop/detail/{id}", name="app_detail")
     */
    public function detail(Produit $produit){
        return $this->render('shop/details.html.twig',[
            'produit' => $produit
        ]);
    }

}
