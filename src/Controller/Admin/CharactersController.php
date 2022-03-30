<?php

namespace App\Controller\Admin;

use App\Entity\Characters;
use App\Entity\Images;
use App\Form\Characters1Type;
use App\Repository\CharactersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/characters")
 */
class CharactersController extends AbstractController
{
    /**
     * @Route("/", name="admin_characters_index", methods={"GET"})
     */
    public function index(CharactersRepository $charactersRepository): Response
    {
        return $this->render('admin/characters/index.html.twig', [
            'characters' => $charactersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/activer/{id}", name="activerCharacters")
     */
    public function activer(Characters $chara, EntityManagerInterface $em)
    {
        $chara->setIsValid(($chara->getIsValid())?false:true);

        $em->persist($chara);
        $em->flush();

        return new Response("true");
    }

    /**
     * @Route("/new", name="admin_characters_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $character = new Characters();
        $form = $this->createForm(Characters1Type::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $character->setIsValid(false);
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
                $character->addImage($img);
            };
            $entityManager->persist($character);
            $entityManager->flush();

            return $this->redirectToRoute('admin_characters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/characters/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_characters_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Characters $character, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Characters1Type::class, $character);
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
                $character->addImage($img);
            };



            $entityManager->flush();

            return $this->redirectToRoute('admin_characters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/characters/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_characters_delete", methods={"POST"})
     */
    public function delete(Request $request, Characters $character, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getId(), $request->request->get('_token'))) {

            $images = $character->getImages();
            if($images){
                foreach($images as $image){
                    $imgName = $this->getParameter("upload_directory") . '/' . $image->getName();

                    if(file_exists($imgName)){
                        unlink($imgName);
                    }
                }
            }


            $entityManager->remove($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_characters_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/supprime/image/{id}", name="DeleteCharaImage", methods={"DELETE"})
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
