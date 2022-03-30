<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\LUC;
use App\Form\LUCType;
use App\Repository\LUCRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/luc")
 */
class LucController extends AbstractController
{
    /**
     * @Route("/", name="luc_index", methods={"GET"})
     */
    public function index(LUCRepository $lUCRepository): Response
    {
        return $this->render('admin/luc/index.html.twig', [
            'l_u_cs' => $lUCRepository->findBy([], ['numbers' => 'DESC'])
        ]);
    }

    /**
     * @Route("/activer/{id}", name="activer")
     */
    public function activer(LUC $luc, EntityManagerInterface $em)
    {
        $luc->setIsValid(($luc->getIsValid())?false:true);

        $em->persist($luc);
        $em->flush();

        return new Response("true");
    }

    /**
     * @Route("/new", name="luc_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lUC = new LUC();
        $form = $this->createForm(LUCType::class, $lUC);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lUC->setIsValid(false);
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
                $lUC->addImage($img);
            };



            $entityManager->persist($lUC);
            $entityManager->flush();

            return $this->redirectToRoute('luc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/luc/new.html.twig', [
            'l_u_c' => $lUC,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="luc_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LUC $lUC, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LUCType::class, $lUC);
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
                $lUC->addImage($img);
            };
            $entityManager->flush();

            return $this->redirectToRoute('luc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/luc/edit.html.twig', [
            'l_u_c' => $lUC,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="luc_delete", methods={"POST"})
     */
    public function delete(Request $request, LUC $lUC, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lUC->getId(), $request->request->get('_token'))) {

            $images = $lUC->getImages();
            if($images){
                foreach($images as $image){
                    $imgName = $this->getParameter("upload_directory") . '/' . $image->getName();

                    if(file_exists($imgName)){
                        unlink($imgName);
                    }
                }
            }


            $entityManager->remove($lUC);
            $entityManager->flush();
        }

        return $this->redirectToRoute('luc_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/supprime/image/{id}", name="DeleteCoverLU", methods={"DELETE"})
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
