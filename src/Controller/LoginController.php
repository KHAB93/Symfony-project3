<?php

namespace App\Controller;

use App\Entity\Sweatshirts;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Login;
use App\Form\LoginType;



final class LoginController extends AbstractController
{
    /**
    * @Route("/login", name="login")  
    */

    public function login(): Response
    {
        return $this->render('login/index.html.twig');
    }

    }