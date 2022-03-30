<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Monsters;
use App\Form\MonstersType;
use App\Repository\MonstersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/monsters")
 */
class MonstersController extends AbstractController
{
    /**
     * @Route("/", name="admin_monsters_index", methods={"GET"})
     */
    public function index(MonstersRepository $monstersRepository): Response
    {
        return $this->render('admin/monsters/index.html.twig', [
            'monsters' => $monstersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_monsters_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $monster = new Monsters();
        $form = $this->createForm(MonstersType::class, $monster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $monster->setIsValid(false);
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
                $monster->addImage($img);
            };
            $entityManager->persist($monster);
            $entityManager->flush();

            return $this->redirectToRoute('admin_monsters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/monsters/new.html.twig', [
            'monster' => $monster,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/activer/{id}", name="ActiverMonster")
     */
    public function activer(Monsters $monster, EntityManagerInterface $em)
    {
        $monster->setIsValid(($monster->getIsValid())?false:true);

        $em->persist($monster);
        $em->flush();

        return new Response("true");
    }

    /**
     * @Route("/{id}", name="admin_monsters_show", methods={"GET"})
     */
    public function show(Monsters $monster): Response
    {
        return $this->render('admin/monsters/show.html.twig', [
            'monster' => $monster,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_monsters_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Monsters $monster, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MonstersType::class, $monster);
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
                $monster->addImage($img);
            };

            $entityManager->flush();

            return $this->redirectToRoute('admin_monsters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/monsters/edit.html.twig', [
            'monster' => $monster,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_monsters_delete", methods={"POST"})
     */
    public function delete(Request $request, Monsters $monster, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$monster->getId(), $request->request->get('_token'))) {

            $images = $monster->getImages();
            if($images){
                foreach($images as $image){
                    $imgName = $this->getParameter("upload_directory") . '/' . $image->getName();

                    if(file_exists($imgName)){
                        unlink($imgName);
                    }
                }
            }



            $entityManager->remove($monster);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_monsters_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/supprime/image/{id}", name="DeleteMonsterImage", methods={"DELETE"})
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
