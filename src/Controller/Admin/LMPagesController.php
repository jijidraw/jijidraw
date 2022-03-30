<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\LMPages;
use App\Form\LMPagesType;
use App\Repository\LMPagesRepository;
use App\Repository\LMSRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/lmpages")
 */
class LMPagesController extends AbstractController
{
    /**
     * @Route("/", name="lmpages_index", methods={"GET"})
     */
    public function index(LMPagesRepository $lMPagesRepository): Response
    {
        return $this->render('admin/lm_pages/index.html.twig', [
            'l_m_pages' => $lMPagesRepository->findAll(),
        ]);
    }
    /**
     * @Route("/LovelyMonsterAdmin/{slug}", name="LMAdminShow")
     */
    public function LMAdminShow($slug, LMSRepository $lms, LMPagesRepository $lmp): Response
    {
        $chapter = $lms->findOneBy(['slug' => $slug]);
        $page = $lmp->findBy([],['pagesNumbers' => 'ASC']);
        return $this->render('admin/lm_pages/storyview.html.twig', [
            'controller_name' => 'ShowController',
            'chapter' => $chapter,
            'page' => $page,
        ]);
    }

    /**
     * @Route("/new", name="lmpages_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lMPage = new LMPages();
        $form = $this->createForm(LMPagesType::class, $lMPage);
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
            $lMPage->addImage($img);


            $entityManager->persist($lMPage);
            $entityManager->flush();

            return $this->redirectToRoute('lmpages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lm_pages/new.html.twig', [
            'l_m_page' => $lMPage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lmpages_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LMPages $lMPage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LMPagesType::class, $lMPage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('lmpages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lm_pages/edit.html.twig', [
            'l_m_page' => $lMPage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="lmpages_delete", methods={"POST"})
     */
    public function delete(Request $request, LMPages $lMPage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lMPage->getId(), $request->request->get('_token'))) {

            $images = $lMPage->getImages();
            if($images){
                foreach($images as $image){
                    $imgName = $this->getParameter("upload_directory") . '/' . $image->getName();

                    if(file_exists($imgName)){
                        unlink($imgName);
                    }
                }
            }



            $entityManager->remove($lMPage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lmpages_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/supprime/image/{id}", name="DeletePageLM", methods={"DELETE"})
     */
    public function deleteCoverLU(Images $img, Request $request, EntityManagerInterface $em){
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $img->getId(), $data['_token'])){
            $name = $img->getName();
            unlink($this->getParameter('upload_directory') . '/' . $name);

            $em->remove($img);
            $em->flush();
            
            return new JsonResponse(['succes' => 1]);
        }else{
            return new JsonResponse(['error' => 'token invalide'], 400);
        }
    }
}
