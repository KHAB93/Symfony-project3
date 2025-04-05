<?php

namespace App\Controller;

use App\Entity\Sweatshirt; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class SweatshirtsController extends AbstractController
{
    /**
     * @Route("/sweatshirts", name="sweatshirts_list", methods={"GET"})
     */
    public function index(): Response
    {
        // Récupération des sweat-shirts depuis le modèle
        $sweatshirts = $this->getDoctrine()->getRepository(Sweatshirt::class)->findAll();

        return $this->render('sweatshirts/index.html.twig', [
            'sweatshirts' => $sweatshirts,
        ]);
    }

    /**
     * @Route("/sweatshirts/{id}", name="sweatshirts_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        // Récupération du sweatshirt depuis le modèle
        $sweatshirt = $this->getDoctrine()->getRepository(Sweatshirt::class)->find($id);

        if (!$sweatshirt) {
            throw $this->createNotFoundException('Sweatshirt not found');
        }

        return $this->render('sweatshirts/show.html.twig', [
            'sweatshirt' => $sweatshirt,
        ]);
    }

    /**
     * @Route("/sweatshirts/new", name="sweatshirts_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $sweatshirt = new Sweatshirt();

        $form = $this->createFormBuilder($sweatshirt)
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('body', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create',
                'attr' => ['class' => 'btn btn-primary mt-3']
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sweatshirt);
            $entityManager->flush();

            return $this->redirectToRoute('sweatshirts_list');
        }

        return $this->render('sweatshirts/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}