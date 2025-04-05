<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(Request $request): Response
    {
        $cart = $request->getSession()->get('cart', []);
        $totalPrice = array_sum(array_column($cart, 'price'));

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'totalPrice' => $totalPrice,
        ]);
    }

    // Method to remove an item
    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function removeItem(Request $request, $id): Response
    {
        $cart = $request->getSession()->get('cart', []);
        unset($cart[$id]); // Remove item
        $request->getSession()->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }
}
