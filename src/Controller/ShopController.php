<?php

namespace App\Controller;

use DateTime;
use App\Entity\Produit;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function detail(Produit $produit, Request $request, EntityManagerInterface $entityManager) : Response
    {

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $entityManager = EntityManagerInterface;
        

        if($form->isSubmitted() && $form->isValid())    // si on a fait une recherche
        {
            $commentaire = $form->get('contenu')->getData();
            $commentaire->setCreatedAt(new DateTime());
            $commentaire->setUser($this->getUser());
            $commentaire->setProduit($this->getProduit());

            $entityManager->persist($user);
            $entityManager->flush();
        }else{
            return $this->render('shop/details.html.twig',[
                'produit' => $produit,
                'commentaireForm' => $form->createView(),
            ]);
        }

        
        return $this->render('shop/details.html.twig',[
            'produit' => $produit, Request,
            'commentaireForm' => $form->createView(),
        ]);
    }
}
