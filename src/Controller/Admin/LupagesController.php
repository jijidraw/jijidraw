<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\LUPages;
use App\Form\LUPagesType;
use App\Form\SearchChapitreType;
use App\Repository\LUCRepository;
use App\Repository\LUPagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/lupages")
 */
class LupagesController extends AbstractController
{
    /**
     * @Route("/", name="lupages_index", methods={"GET"})
     */
    public function index(LUPagesRepository $lUPagesRepository, LUCRepository $chapter, Request $request): Response
    {
         
        return $this->render('admin/lupages/index.html.twig', [
            'l_u_pages' => $lUPagesRepository->findAll(),
            'chapters' => $chapter->findAll(),
        ]);
    }

    /**
     * @Route("/LittleUniverseAdmin/{slug}", name="LUAdminShow")
     */
    public function LUAdminShow($slug, LUCRepository $luc, LUPagesRepository $lup): Response
    {
        $chapter = $luc->findOneBy(['slug' => $slug]);
        $page = $lup->findBy([],['pagesNumbers' => 'ASC']);
        return $this->render('admin/lupages/chapterview.html.twig', [
            'controller_name' => 'ShowController',
            'chapter' => $chapter,
            'page' => $page,
        ]);
    }

    /**
     * @Route("/new", name="lupages_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lUPage = new LUPages();
        $form = $this->createForm(LUPagesType::class, $lUPage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $empty = $form->get('image')->getData();

            $images = $form->get('image')->getData();
            $fichier = md5(uniqid()) . '.' . $images->guessExtension();
            $images->move(
                $this->getParameter('upload_directory'),
                $fichier
            );

            $img = new Images();
            $img->setName($fichier);
            $lUPage->addImage($img);

            $entityManager->persist($lUPage);
            $entityManager->flush();

            return $this->redirectToRoute('lupages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lupages/new.html.twig', [
            'l_u_page' => $lUPage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lupages_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LUPages $lUPage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LUPagesType::class, $lUPage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('lupages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lupages/edit.html.twig', [
            'l_u_page' => $lUPage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="lupages_delete", methods={"POST"})
     */
    public function delete(Request $request, LUPages $lUPage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lUPage->getId(), $request->request->get('_token'))) {

            $images = $lUPage->getImages();
            if($images){
                foreach($images as $image){
                    $imgName = $this->getParameter("upload_directory") . '/' . $image->getName();

                    if(file_exists($imgName)){
                        unlink($imgName);
                    }
                }
            }

            $entityManager->remove($lUPage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lupages_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/supprime/image/{id}", name="DeletePageLU", methods={"DELETE"})
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
