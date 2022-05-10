<?php

namespace App\Controller;

use DateTime;
use App\Entity\Produit;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->render('shop/index.html.twig', [
            'produits' => $produits,
        ]);
    }


    /**
     * @Route("/shop/detail/{id}", name="app_detail")
     */
    public function detail(Produit $produit, EntityManagerInterface $entityManager, Request $request, CommentaireRepository $repo){

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())    // si on a fait une recherche
        {
            $commentaire->setCreatedAt(new DateTime());
            $commentaire->setUser($this->getUser());
            $commentaire->setProduit($produit);

            $entityManager->persist($commentaire);
            $entityManager->flush();
            
            return $this->redirect($request->getUri());
        }
        $commentaires = $repo->getCommentaireByProduitId($produit->getId());
        return $this->render('shop/details.html.twig',[
            'produit' => $produit,
            'commentaireForm' => $form->createView(),
            'commentaires' => $commentaires
        ]);
    }

}
