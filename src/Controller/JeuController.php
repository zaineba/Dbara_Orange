<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuController extends AbstractController
{
    #[Route('/jeu', name: 'app_jeu')]
    public function index(): Response
    {
        return $this->render('jeu/jeuAdmin.html.twig', [
            'controller_name' => 'JeuController',
        ]);
    }

    #[Route('/jeu/a7la-tawla', name: 'app_a7la_tawla')]
public function a7laTawla(): Response
{
    return $this->render('jeu/a7la_tawla.html.twig');
}

#[Route('/jeu/tchanchina', name: 'app_tchanchina')]
public function tchanchina(): Response
{
    return $this->render('jeu/tchanchina.html.twig');
}

#[Route('/jeu/quiz-har-hlow', name: 'app_quiz')]
public function quizHarHlow(): Response
{
    return $this->render('jeu/quiz.html.twig');
}

}
