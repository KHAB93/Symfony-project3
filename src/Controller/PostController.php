<?php

namespace App\Controller;

use App\Entity\Sweatshirts;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(ManagerRegistry $manager): Response
    {
        $sweatshirts = $manager->getRepository(Sweatshirts::class)->findAll();

        return $this->render('post/index.html.twig', [
            'sweatshirts' => $sweatshirts,
        ]);
    }
}
