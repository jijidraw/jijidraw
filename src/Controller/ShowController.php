<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CharactersRepository;
use App\Repository\LMPagesRepository;
use App\Repository\LMSRepository;
use App\Repository\LUCRepository;
use App\Repository\LUPagesRepository;
use App\Repository\MonstersRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\OrderBy;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @Route("/LittleUniverse/{slug}", name="LUShow")
     */
    public function LUShow($slug, LUCRepository $luc, LUPagesRepository $lup, Request $request, FlashyNotifier $flashy, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $chapter = $luc->findOneBy(['slug' => $slug]);
        if(!$chapter){
            throw new NotFoundHttpException('Chapitre non trouvé');
        }
        $comment = new Comment;
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new DateTime());
            $comment->setChapter($chapter);
            $comment->setUser($user);

            $em->persist($comment);
            $em->flush();
            $flashy->success('Votre commentaire à bien été envoyé.');
            return $this->redirectToRoute('home');
        }
        $page = $lup->findBy([],['pagesNumbers' => 'ASC']);
        return $this->render('show/LU.html.twig', [
            'controller_name' => 'ShowController',
            'chapter' => $chapter,
            'page' => $page,
            'form' => $commentForm->createView()
        ]);
    }
    /**
     * @Route("/LovelyMonster/{slug}", name="LMShow")
     */
    public function LMShow($slug, LMSRepository $lms, LMPagesRepository $lmp, FlashyNotifier $flashy, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
    
        $chapter = $lms->findOneBy(['slug' => $slug]);
        if(!$chapter){
            throw new NotFoundHttpException('Histoire non trouvé');
        }
        $comment = new Comment;
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new DateTime());
            $comment->setStory($chapter);
            $comment->setUser($user);

            $em->persist($comment);
            $em->flush();
            $flashy->success('Votre commentaire à bien été envoyé.');
            return $this->redirectToRoute('home');
        }
        $page = $lmp->findBy([],['pagesNumbers' => 'ASC']);
        return $this->render('show/LM.html.twig', [
            'controller_name' => 'ShowController',
            'chapter' => $chapter,
            'page' => $page,
            'form' => $commentForm->createView()
        ]);
    }
    /**
     * @Route("/LittleUniverseList/Personnages", name="LUChara")
     */
    public function CharaList(CharactersRepository $chara): Response
    {
        
        
        return $this->render('show/charalist.html.twig', [
            'controller_name' => 'ShowController',
            'chara' => $chara->findBy(['IsValid' => true])
            
        ]);
    }
    /**
     * @Route("/LovelyMonsterList/Monster", name="LMM")
     */
    public function MonsterList(MonstersRepository $chara): Response
    {
        
        
        return $this->render('show/monsterlist.html.twig', [
            'controller_name' => 'ShowController',
            'chara' => $chara->findBy(['IsValid' => true])
            
        ]);
    }
}
