<?php

namespace App\Controller;

use App\Service\StripeService;
use App\Entity\Sweatshirts;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(ManagerRegistry $manager): Response
    {
        $sweatshirts = $manager->getRepository(Sweatshirts::class)->findAll();

        foreach ($sweatshirts as $sweatshirt) {
            $imageName = $sweatshirt->getId() . '.jpeg'; 
            $sweatshirt->setImage($imageName);
            $manager->getManager()->persist($sweatshirt);
        }
        $manager->getManager()->flush();

        return $this->render('products/index.html.twig', [
            'sweatshirts' => $sweatshirts,
        ]);
    }

    #[Route('/product/{id}', name: 'product_show')]
    public function show(ManagerRegistry $manager, int $id): Response
    {
        $sweatshirt = $manager->getRepository(Sweatshirts::class)->find($id);

        if (!$sweatshirt) {
            throw $this->createNotFoundException('Sweatshirt not found');
        }

        return $this->render('products/show.html.twig', [
            'sweatshirt' => $sweatshirt,
        ]);
    }

    // Create a method in your controller
public function showSweatshirt($sweatshirtId)
{
    // Fetch the sweatshirt from the repository
    $sweatshirt = $this->getDoctrine()->getRepository(Sweatshirts::class)->find($sweatshirtId);

    // Check if sweatshirt is found
    if (!$sweatshirt) {
        throw $this->createNotFoundException('Sweatshirt not found');
    }

    // Render the view with sweatshirt data
    return $this->render('sweatshirt/show.html.twig', [
        'sweatshirt' => $sweatshirt,
    ]);
}

    #[Route('/cart', name: 'cart')]
    public function addToCart(Request $request, ManagerRegistry $manager): Response
    {
        // Récupérer les données du produit
        $size = $request->request->get('size');
        $quantity = $request->request->get('quantity');
        $sweatshirtId = $request->request->get('sweatshirt_id'); // Assurez-vous d'envoyer cet ID depuis le formulaire
    
        // Logique pour ajouter l'élément au panier
        // Exemple fictif d'ajout au panier
        $cart = $request->getSession()->get('cart', []);
        $cart[] = [
            'id' => $sweatshirtId,
            'size' => $size,
            'quantity' => $quantity,
        ];
        $request->getSession()->set('cart', $cart);
    
        // Redirection après l'ajout au panier
        return $this->redirectToRoute('app_products'); // Redirection vers la liste des produits
    }

    public function products(Request $request)
{
    $minPrice = $request->query->get('min_price');
    $maxPrice = $request->query->get('max_price');

    // Récupérez les sweatshirts en fonction des prix spécifiés
    $sweatshirts = $this->getDoctrine()->getRepository(Sweatshirt::class)->findByPriceRange($minPrice, $maxPrice);

    return $this->render('products.html.twig', [
        'sweatshirts' => $sweatshirts,
    ]);
    
}







}