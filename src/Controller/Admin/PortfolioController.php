<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Portfolio;
use App\Form\PortfolioType;
use App\Repository\PortfolioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/portfolio")
 */
class PortfolioController extends AbstractController
{
    /**
     * @Route("/", name="portfolio_index", methods={"GET"})
     */
    public function index(PortfolioRepository $portfolioRepository): Response
    {
        return $this->render('admin/portfolio/index.html.twig', [
            'portfolios' => $portfolioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="portfolio_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $portfolio = new Portfolio();
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('image')->getData();
            $fichier = md5(uniqid()) . '.' . $images->guessExtension();
            $images->move(
                $this->getParameter('upload_directory'),
                $fichier
            );

            $img = new Images();
            $img->setName($fichier);
            $portfolio->addImage($img);

            $entityManager->persist($portfolio);
            $entityManager->flush();

            return $this->redirectToRoute('portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/portfolio/new.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="portfolio_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('image')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('upload_directory'),
                    $fichier
                );
                
                $img = new Images();
                $img->setName($fichier);
                $portfolio->addImage($img);

            $entityManager->flush();

            return $this->redirectToRoute('portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/portfolio/edit.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="portfolio_delete", methods={"POST"})
     */
    public function delete(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portfolio->getId(), $request->request->get('_token'))) {

            $images = $portfolio->getImages();
            if($images){
                foreach($images as $image){
                    $imgName = $this->getParameter("upload_directory") . '/' . $image->getName();
                    if(file_exists($imgName)){
                        unlink($imgName);
                    }
                }
            }

            $entityManager->remove($portfolio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('portfolio_index', [], Response::HTTP_SEE_OTHER);
    }
}
