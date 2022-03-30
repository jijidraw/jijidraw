<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\LMS;
use App\Form\LMSType;
use App\Repository\LMSRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/lms")
 */
class LmsController extends AbstractController
{
    /**
     * @Route("/", name="lms_index", methods={"GET"})
     */
    public function index(LMSRepository $lMSRepository): Response
    {
        return $this->render('admin/lms/index.html.twig', [
            'l_ms' => $lMSRepository->findAll(),
        ]);
    }
    /**
     * @Route("/activer/{id}", name="active")
     */
    public function activer(LMS $lms, EntityManagerInterface $em)
    {
        $lms->setIsValid(($lms->getIsValid())?false:true);

        $em->persist($lms);
        $em->flush();

        return new Response("true");
    }

    /**
     * @Route("/new", name="lms_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lM = new LMS();
        $form = $this->createForm(LMSType::class, $lM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lM->setIsValid(false);
            $empty = $form->get('image')->getData();

            if (!empty($empty)){

                $images = $form->get('image')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('upload_directory'),
                    $fichier
                );
                
                $img = new Images();
                $img->setName($fichier);
                $lM->addImage($img);
            };
                
            $entityManager->persist($lM);
            $entityManager->flush();

            return $this->redirectToRoute('lms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lms/new.html.twig', [
            'l_m' => $lM,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lms_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LMS $lM, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LMSType::class, $lM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $empty = $form->get('image')->getData();

            if (!empty($empty)){

                $images = $form->get('image')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('upload_directory'),
                    $fichier
                );
                
                $img = new Images();
                $img->setName($fichier);
                $lM->addImage($img);
            };
            $entityManager->flush();

            return $this->redirectToRoute('lms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/lms/edit.html.twig', [
            'l_m' => $lM,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="lms_delete", methods={"POST"})
     */
    public function delete(Request $request, LMS $lM, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lM->getId(), $request->request->get('_token'))) {


            $images = $lM->getImages();
            if($images){
                foreach($images as $image){
                    $imgName = $this->getParameter("upload_directory") . '/' . $image->getName();

                    if(file_exists($imgName)){
                        unlink($imgName);
                    }
                }
            }

            $entityManager->remove($lM);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lms_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/supprime/image/{id}", name="DeleteCoverLM", methods={"DELETE"})
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
