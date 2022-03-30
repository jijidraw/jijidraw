<?php

namespace App\Controller;

use App\Entity\Monsters;
use App\Repository\CharactersRepository;
use App\Repository\LMSRepository;
use App\Repository\LUCRepository;
use App\Repository\MonstersRepository;
use App\Repository\PortfolioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BDController extends AbstractController
{
    /**
     * @Route("/LittleUniverse", name="LittleUniverse")
     */
    public function listLU(LUCRepository $lu, CharactersRepository $chara): Response
    {
        return $this->render('bd/LU.html.twig', [
            'controller_name' => 'BDController',
            'lu' => $lu->findBy(['is_valid' => true], ['numbers' => 'DESC']),
            'chara' => $chara->findBy(['IsValid' => true], [], 5)
        ]);
    }
    /**
     * @Route("/LovelyMonster", name="LovelyMonster")
     */
    public function listLM(LMSRepository $lm, MonstersRepository $chara): Response
    {
        return $this->render('bd/LM.html.twig', [
            'controller_name' => 'BDController',
            'lm' => $lm->findBy(['is_valid' => true], ['numbers' => 'DESC']),
            'chara' => $chara->findBy(['IsValid' => true], [], 5)
        ]);
    }
    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function portfolio(PortfolioRepository $port): Response
    {
        return $this->render('bd/portfolio.html.twig', [
            'controller_name' => 'BDController',
            'port' => $port->findAll()
        ]);
    }
}
