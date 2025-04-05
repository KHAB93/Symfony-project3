<?php

namespace App\Controller;

use App\Entity\Sweatshirts;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductidController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product_view", requirements={"id"="\d+"})
     */
    public function index(int $id, ManagerRegistry $manager): Response
    {
        $sweatshirts = $manager->getRepository(Sweatshirts::class)->find($id);

        if (!$sweatshirts) {
            throw $this->createNotFoundException('Le sweat-shirt n\'a pas été trouvé.');
        }

        return $this->render('productid/show.html.twig', [
            'sweatshirt' => $sweatshirts,
        ]);
    }

    /**
     * @Route("/add-to-cart/{id}", name="add_to_cart")
     */
    public function addToCart(Request $request, int $id, ManagerRegistry $manager): Response
    {
        // Handle the addition to cart here
        $sweatshirt = $manager->getRepository(Sweatshirts::class)->find($id);

        if (!$sweatshirt) {
            throw $this->createNotFoundException('Le sweat-shirt n\'a pas été trouvé.');
        }

        // Retrieve the size and quantity from the form
        $size = $request->request->get('size');
        $quantity = $request->request->get('quantity');

        // Add the item to the cart using a session or a cart service

        // Redirect to some page, for example, the cart page or the product page
        return $this->redirectToRoute('product_view', ['id' => $id]);
    }
}
