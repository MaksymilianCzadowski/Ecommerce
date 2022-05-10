<?php

namespace App\Controller;

use DateTime;
use App\Entity\Produit;
use App\Entity\Commentaire;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="app_shop")
     */
    public function shop(ProduitRepository $repo): Response
    {
        $produits = $repo->findAll();
        return $this->render('shop/index.html.twig', [
            'produits' => $produits,
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

     /**
     * @Route("/shop/detail/{id}", name="app_detail")
     */
    public function commentaire(Request $request, Commentaire $commentaire): Response{
        
        $form = $this->createForm(commentaireType::class);
        $form->handleRequest($request);

        

        if($form->isSubmitted() && $form->isValid())    // si on a fait une recherche
        {
            $commentaire = $form->get('contenu')->getData();
            $commentaire->setCreatedAt(new DateTime());
            $commentaire->setUser($this->getUser());
            $commentaire->setProduit($this->getProduit());
        }else{
            return $this->render('shop/details.html.twig');
        }

        $entityManager->persist($user);
        $entityManager->flush();
        
        
        return $this->render('shop/details.html.twig',[
    
        ]);
    }
}
