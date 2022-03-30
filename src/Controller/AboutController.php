<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="about")
     */
    public function index(): Response
    {
        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
    /**
     * @Route("/mentionslégales", name="mentions")
     */
    public function legal(): Response
    {
        return $this->render('about/legal.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }
}
