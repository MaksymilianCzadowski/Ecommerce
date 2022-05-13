<?php

namespace App\Controller;

use DateTime;
use App\Entity\Produit;
use App\Entity\Commentaire;
use App\Service\CartService;
use App\Form\CommentaireType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
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
        $commentaires = $repo->getCommentaireByProduitId($produit);
        return $this->render('shop/details.html.twig',[
            'produit' => $produit,
            'commentaireForm' => $form->createView(),
            'commentaires' => $commentaires
        ]);
    }

    /**
    * @Route("/cart", name="app_cart")
    */
    public function panier(RequestStack $rs, ProduitRepository $repo): Response
    {
        $session = $rs->getSession();
        $cart = $session->get('cart', []);
        $qt = 0; // $qt contient le nb total de produit dans mon pannier


        // on va créer un tableau qui contiendra des objets produit et les quantités de chaque objet
        $cartWithData = [];

        // pour chaque id dans le tableau cart, j'ajoute une case à cartWithData
        // cahque cas de $cartWithData est un tableau associatif contenant 2 cases : 
        // une case 'produit' est une case 'quantity' 
        foreach($cart as $id => $quantity){
            $cartWithData[] = [
                'produit' => $repo->find($id),
                'quantity' => $quantity
            ];
            $qt += $quantity;
        }

        $session->set('qt', $qt);
        $total = 0;

        // pour chaque produit dans mon panier, je récupère le total de produit puis je l'ajoute au total fianl

        foreach($cartWithData as $item){
            $totalItem = $item['produit']->getPrix() * $item['quantity'];
            $total+= $totalItem;
        }

        return $this->render('shop/panier.html.twig', [
            'items' => $cartWithData,
            'total' => $total,
        ]);
    }

     /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cs)
    {
    
        $cs->add($id);
        return $this->redirectToRoute('app_cart');
    }

     /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, RequestStack $rs)
    {
        $session = $rs->getSession();
        $cart = $session->get('cart', []);

        // si l'id existe dans mon panier, je le supprime du tableau via unset()
        if(!empty($cart[$id]))
            unset($cart[$id]);

        $session->set('cart', $cart);
        return $this->redirectToRoute('app_cart');
    }

     /**
     * @Route("/cart/confirmOrder", name="cart_confirm")
     */
    public function confirmOrder(RequestStack $rs)
    {
        $session = $rs->getSession();
        $session->remove('cart');

        return $this->render('shop/confirmCart.html.twig', [
            
        ]);


    }

    

}
