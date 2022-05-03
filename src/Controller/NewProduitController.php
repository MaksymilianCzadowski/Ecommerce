<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewProduitController extends AbstractController
{
    /**
     * @Route("/new/produit", name="app_new_produit")
     */
    public function form(Request $request): Response
    {
        $produit = new Produit;
        $form = $this->createForm(ProduitType::class);
        // createForm() permet de récupérer le formulaire :)
        dump($request);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($produit);
            $manager->flush();
            return $this->redirectToRoute('app_shop');
        }
        return $this->render('new_produit/index.html.twig', [
            'formArticle' => $form->createView(),
        ]);
    }
}
