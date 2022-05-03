<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewProduitController extends AbstractController
{
    /**
     * @Route("/new/produit", name="app_new_produit")
     */
    public function index(): Response
    {
        return $this->render('new_produit/index.html.twig', [
            'controller_name' => 'NewProduitController',
        ]);
    }
}
