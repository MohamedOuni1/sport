<?php

namespace App\Controller;
use App\Entity\Equipe;
use App\Form\ClassementType;
use App\Entity\Classement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class GClasseement extends AbstractController
{
    #[Route('/home6', name: 'classement_list')]
    public function home6()
    {
        $classements = $this->getDoctrine()->getRepository(Classement::class)->findAll();
        return $this->render('classements/index.html.twig', ['classements' => $classements]);
    }

    /**
     * @Route("/classement/new", name="new_classement")
     * Method({"GET", "POST"})
     */
    public function newC(Request $request)
    {
        $classement = new Classement();
        $form = $this->createForm(ClassementType::class, $classement);
        $form = $this->createFormBuilder($classement)
            ->add('equipe', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nome',
                'label' => 'Nom Equipe'
            ])
            ->add('nbrm', NumberType::class, ['label' => 'Nombre de match jouées'])
            ->add('nbrmg', NumberType::class, ['label' => 'Nombre de match gagnés'])
            ->add('nbrmp', NumberType::class, ['label' => 'Nombre de match perdus'])
            ->add('nbrmn', NumberType::class, ['label' => 'Nombre de match nulls'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $classement = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classement);
            $entityManager->flush();
            return $this->redirectToRoute('classement_list');
        }
        return $this->render('classements/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/classeement/edit/{id}", name="edit_classement")
     * Method({"GET", "POST"})
     */
    public function editc(Request $request, $id)
    {
        $classement = new Classement();
        $classement = $this->getDoctrine()->getRepository(Classement::class)->find($id);
        $form = $this->createFormBuilder($classement)
            ->add('nbrm', NumberType::class, ['label' => 'Nombre de match jouées'])
            ->add('nbrmg', NumberType::class, ['label' => 'Nombre de match gagnés'])
            ->add('nbrmp', NumberType::class, ['label' => 'Nombre de match perdus'])
            ->add('nbrmn', NumberType::class, ['label' => 'Nombre de match nulls'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('classement_list');
        }
        return $this->render('classements/edit.html.twig', ['form' => $form->createView()]);
    }
}