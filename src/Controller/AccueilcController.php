<?php

namespace App\Controller;

use App\Entity\Sweatshirts;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilcController extends AbstractController
{
    #[Route('/accueilc', name: 'app_accueilc')]
    public function index(ManagerRegistry $manager): Response
    {
        $sweatshirts = $manager->getRepository(Sweatshirts::class)->findBy(['id' => [12, 15, 9]]);

        foreach ($sweatshirts as $sweatshirt) {
            
            $imageName = $sweatshirt->getId() . '.jpeg'; 
            $sweatshirt->setImage($imageName);
            $manager->getManager()->persist($sweatshirt);
        }
        $manager->getManager()->flush(); 

        return $this->render('accueilc/index.html.twig', [
            'sweatshirts' => $sweatshirts,
        ]);

        // Vérification de l'authentification
        $isLoggedIn = $this->getUser() !== null;

        return $this->render('accueilc/index.html.twig', [
            'isLoggedIn' => $isLoggedIn,
        ]);
    }

   
}