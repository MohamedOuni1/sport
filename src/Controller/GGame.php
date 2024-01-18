<?php

namespace App\Controller;
use App\Entity\Category;
use App\Entity\Game;
use App\Entity\Equipe;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class GGame extends AbstractController
{
    #[Route('/home3', name: 'match_list')]
    public function home3()
    {
        $games = $this->getDoctrine()->getRepository(Game::class)->findAll();
        return $this->render('matchs/index.html.twig', ['games' => $games]);
    }

    #[Route('/home7', name: 'match_t_list')]
    public function home7()
    {
        $games = $this->getDoctrine()->getRepository(Game::class)->findAll();
        return $this->render('matchs/indext.html.twig', ['games' => $games]);
    }

    /**
     * @Route("/match/new", name="new_match", methods={"GET", "POST"})
     */
    public function newG(Request $request)
    {
        $game = new Game();

        // Créer le formulaire
        $form = $this->createFormBuilder($game)
            ->add('datedumatch', DateTimeType::class, [
                'label' => 'Date du Rencontre',
            ])
            ->add('stade', TextType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'nomcategory',
                'label' => 'Categorie du match',
            ])
            ->add('ville', TextType::class)
            ->add('equipe1', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nome',
                'label' => 'Equipe Domicile',
            ])
            ->add('score1', NumberType::class)
            ->add('equipe2', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nome',
                'label' => 'Equipe Exterieur',
            ])
            ->add('score2', NumberType::class)
            ->add('lien', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('match_list');
        }

        return $this->render('matchs/ajout.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/game/edit/{id}", name="edit_game")
     * Method({"GET", "POST"})
     */
    public function editg(Request $request, $id)
    {
        $game = new Game();
        $game = $this->getDoctrine()->getRepository(Game::class)->find($id);

        $form = $this->createFormBuilder($game)
            ->add('datedumatch', DateTimeType::class, [
                'label' => 'Date du Rencontre',
            ])
            ->add('stade', TextType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'nomcategory',
                'label' => 'Categorie du match'
            ])
            ->add('ville', TextType::class)
            ->add('equipe1', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nome',
                'label' => 'Equipe Domicile'
            ])
            ->add('score1', NumberType::class)
            ->add('equipe2', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nome',
                'label' => 'Equipe Exterieur'
            ])
            ->add('score2', NumberType::class)
            ->add('lien', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('match_list');
        }

        return $this->render('matchs/ajout.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/match/delete/{id}", name="delete_match")
     */
    public function delete3(Request $request, $id): Response
    {
        $c = $this->getDoctrine()
            ->getRepository(Game::class)
            ->find($id);
        if (!$c) {
            throw $this->createNotFoundException(
                'pas de match  avec id = ' . $id
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($c);

        $entityManager->flush();
        return $this->redirectToRoute('equipe_list');
    }

   
}
