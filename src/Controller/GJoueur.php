<?php

namespace App\Controller;
use App\Entity\Category;
use App\Entity\Equipe;
use App\Entity\Joueur;
use App\Entity\Image;
use App\Form\JoueurType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class GJoueur extends AbstractController
{
    #[Route('/arrire', name: 'arriere')]
    public function arriere()
    {
        return $this->render('page1/arriere.html.twig');
    }

    #[Route('/home', name: 'joueur_list')]
    public function home()
    {
        $joueurs = $this->getDoctrine()->getRepository(Joueur::class)->findAll();
        return $this->render('joueurs/index.html.twig', ['joueurs' => $joueurs]);
    }

    /**
     * @Route("/joueur/new", name="new_joueur")
     * Method({"GET", "POST"})
     */
    public function newJoueurs(Request $request)
    {
        $joueur = new Joueur();
        $form = $this->createForm(JoueurType::class, $joueur);
        $form = $this->createFormBuilder($joueur)
            ->add('nom', TextType::class, ['label' => 'Nom joueur'])
            ->add('datedenaissance', DateType::class, ['label' => 'Date de naissance'])
            ->add('datefin', DateType::class, ['label' => 'Date fin de contrat'])
            ->add('pied', ChoiceType::class, [
                'choices' => [
                    'Droit' => 'Droit',
                    'Gauche' => 'Gauche',
                ],
            ])
            ->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'nomcategory'])
            ->add('poste', ChoiceType::class, [
                'choices' => [
                    'Gardien' => 'Gardien',
                    'Defenseur' => 'Defenseur',
                    'Milieu' => 'Milieu',
                    'Attaquant' => 'Attaquant',
                ],
            ])
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'url',
            ])

            
            ->add('nationalite', TextType::class)
            ->add('agent', TextType::class, ['label' => 'Nom agent'])
            ->add('equipe', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nome',
                'label' => 'Nom Equipe',
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $joueur = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($joueur);
            $entityManager->flush();
            return $this->redirectToRoute('joueur_list');
        }
        return $this->render('joueurs/ajout.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/joueur/{equipeID}", name="new_joueurr")
     * Method({"GET", "POST"})
     */
    public function newJoueur(Request $request, $equipeID)
    {
        $joueur = new Joueur();
        $form = $this->createFormBuilder($joueur)
            ->add('nom', TextType::class, ['label' => 'Nom joueur'])
            ->add('datedenaissance', DateType::class, ['label' => 'Date de naissance'])
            ->add('datefin', DateType::class, ['label' => 'Date fin de contrat'])
            ->add('pied', ChoiceType::class, [
                'choices' => [
                    'Droit' => 'Droit',
                    'Gauche' => 'Gauche',
                ],
            ])
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'url',
            ])
            
            ->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'nomcategory'])
            ->add('poste', ChoiceType::class, [
                'choices' => [
                    'Gardien' => 'Gardien',
                    'Defenseur' => 'Defenseur',
                    'Milieu' => 'Milieu',
                    'Attaquant' => 'Attaquant',
                ],
            ])
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'url',
            ])

            ->add('nationalite', TextType::class)
            ->add('agent', TextType::class, ['label' => 'Nom agent'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $equipe = $em->getRepository(Equipe::class)->find($equipeID);
            $joueur->setEquipe($equipe);
            $em->persist($joueur);
            $em->flush();
            return $this->redirectToRoute('joueur_list');
        }
        return $this->render('joueurs/ajoutspec.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/joueu/{id}", name="joueur_show")
     */
    public function show($id)
    {
        $joueur = $this->getDoctrine()->getRepository(Joueur::class)->find($id);
        return $this->render('joueurs/show.html.twig', ['joueur' => $joueur]);
    }

    /**
     * @Route("/voir/{id}", name="equipe_details")
     */
    public function show4($id)
    {
        $equipe = $this->getDoctrine()->getRepository(Equipe::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $listJoueurs = $em->getRepository(Joueur::class)->findBy(['equipe' => $equipe]);
        if (!$equipe) {
            throw $this->createNotFoundException('No equipe found for id ' . $id);
        }
        return $this->render('joueurs/indexspec.html.twig', [
            'listJoueurs' => $listJoueurs,
            'equipe' => $equipe
        ]);
    }

    /**
     * @Route("/voir/{id}", name="equipe_stats")
     */
    public function show5($id)
    {
        $stat = $this->getDoctrine()->getRepository(Joueur::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $listJoueurs = $em->getRepository(Joueur::class)->findBy(['stat' => $stat]);
        if (!$stat) {
            throw $this->createNotFoundException('No stat found for id ' . $id);
        }
        return $this->render('joueurs/indexspec.html.twig', [
            'listJoueurs' => $listJoueurs,
            'stat' => $stat
        ]);
    }

    /**
     * @Route("/joueur/edit/{id}", name="edit_joueur")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $joueur = new Joueur();
        $joueur = $this->getDoctrine()->getRepository(Joueur::class)->find($id);
        $form = $this->createFormBuilder($joueur)
            ->add('nom', TextType::class, ['label' => 'Nom joueur'])
            ->add('datedenaissance', DateType::class, ['label' => 'Date de naissance'])
            ->add('datefin', DateType::class, ['label' => 'Date fin de contrat'])
            ->add('pied', ChoiceType::class, [
                'choices' => [
                    'Droit' => 'Droit',
                    'Gauche' => 'Gauche',
                ],
            ])
            ->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'nomcategory'])
            ->add('poste', ChoiceType::class, [
                'choices' => [
                    'Gardien' => 'Gardien',
                    'Defenseur' => 'Defenseur',
                    'Milieu' => 'Milieu',
                    'Attaquant' => 'Attaquant',
                ],
            ])
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'url',
            ])

            ->add('nationalite', TextType::class)
            ->add('agent', TextType::class, ['label' => 'Nom agent'])
            ->add('equipe', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nome',
                'label' => 'Nom Equipe'
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('joueur_list');
        }

        return $this->render('joueurs/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/joueur/delete/{id}", name="delete_joueur")
     */
    public function delete(Request $request, $id): Response
    {
        $c = $this->getDoctrine()->getRepository(Joueur::class)->find($id);
        if (!$c) {
            throw $this->createNotFoundException('pas de joueur avec id = ' . $id);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($c);
        $entityManager->flush();
        return $this->redirectToRoute('joueur_list');
    }
}
