<?php

namespace App\Controller;

use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewProduitController extends AbstractController
{
    /**
     * @Route("/new/produit", name="app_new_produit")
     */
    public function form(): Response
    {
        $form = $this->createForm(ProduitType::class);
        // createForm() permet de récupérer le formulaire :)
        return $this->render('new_produit/index.html.twig', [
            'formArticle' => $form->createView(),
        ]);
    }
}
