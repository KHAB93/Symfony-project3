<?php

namespace App\Controller;

use App\Entity\Sweatshirts;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Register;
use App\Form\RegisterType;



final class RegisterController extends AbstractController
{
  
    /**
    * @Route("/register", name="app_register")  
    */

    public function index(ManagerRegistry $manager): Response
    {
        $sweatshirts = $manager->getRepository(Sweatshirts::class)->findAll();

        return $this->render('register/index.html.twig', [
            'sweatshirts' => $sweatshirts,
        ]);
    }

    /**
    * @Route("/register/save", name="add_register")  
    */

    public function save(Request $request, ManagerRegistry $manager): Response
{
        $register = new Register();
        $form = $this->createForm(RegisterType ::class, $register);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $om = $manager->getManager();
            $om->persist($register);
            $om->flush();

            return $this->redirectToRoute('app_register');
        }

        return $this->render('register/save.html.twig', [
            'registerForm' => $form->createView(),

        ]);


}
}