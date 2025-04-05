<?php
namespace App\Controller;

use App\Entity\Sweatshirts; 
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class AdminController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/sweatshirts", name="admin_sweatshirts_list", methods={"GET"})
     */
    public function index(): Response
    {
        $sweatshirts = $this->entityManager->getRepository(Sweatshirts::class)->findAll();

        return $this->render('admin/sweatshirts/list.html.twig', [
            'sweatshirts' => $sweatshirts,
        ]);
    }

    /**
     * @Route("/admin/sweatshirts/{id}", name="admin_sweatshirts_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $sweatshirt = $this->entityManager->getRepository(Sweatshirts::class)->find($id);

        if (!$sweatshirt) {
            throw $this->createNotFoundException('Sweatshirt not found');
        }

        return $this->render('admin/sweatshirts/show.html.twig', [
            'sweatshirt' => $sweatshirt,
        ]);
    }

    /**
     * @Route("/admin/sweatshirts/{id}/edit", name="admin_sweatshirt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sweatshirts $sweatshirt): Response
    {
        $form = $this->createFormBuilder($sweatshirt)
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('price', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('size', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('stock', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Modifier',
                'attr' => ['class' => 'btn btn-primary mt-3']
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush(); // Enregistre les modifications

            return $this->redirectToRoute('admin_sweatshirts_list'); // Redirige vers la liste des sweat-shirts
        }

        return $this->render('admin/sweatshirts/edit.html.twig', [
            'form' => $form->createView(),
            'sweatshirt' => $sweatshirt,
        ]);
    }

    /**
     * @Route("/admin/sweatshirts/{id}/delete", name="admin_sweatshirt_delete", methods={"POST"})
     */
    public function delete(Request $request, Sweatshirts $sweatshirt): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sweatshirt->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($sweatshirt);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('admin_sweatshirts_list');
    }

    /**
     * @Route("/admin/add", name="admin_sweatshirt_add", methods={"GET", "POST"})
     */
    public function add(Request $request): Response
    {
        $sweatshirt = new Sweatshirts();

        $form = $this->createFormBuilder($sweatshirt)
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('price', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('size', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('stock', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create',
                'attr' => ['class' => 'btn btn-primary mt-3']
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($sweatshirt);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_sweatshirts_list');
        }

        return $this->render('admin/sweatshirts/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}