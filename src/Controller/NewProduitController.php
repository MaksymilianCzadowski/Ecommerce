<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewProduitController extends AbstractController
{
    /**
     * @Route("/new/produit", name="app_new_produit")
     */
    public function form(Request $request, EntityManagerInterface $manager, Produit $produit = null): Response
    {
        
        if(!$produit) {
            $produit = new Produit;
        }

        $form = $this->createForm(ProduitType::class, $produit);
        // createForm() permet de récupérer le formulaire :)
        
        $form->handleRequest($request);
        dump($request);


        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($produit);
            $manager->flush();
            return $this->redirectToRoute('app_shop');
        }
        return $this->render('new_produit/index.html.twig', [
            'formProduit' => $form->createView(),
        ]);
    }
}
