<?php

namespace App\Controller;
use App\Entity\Equipe;
use App\Form\EquipeType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class GEquipe extends AbstractController
{
    #[Route('/home1', name: 'equipe_list')]
    public function home1()
    {
        $equipes = $this->getDoctrine()->getRepository(Equipe::class)->findAll();
        return $this->render('equipes/index.html.twig', ['equipes' => $equipes]);
    }

    /**
     * @Route("/equipe/new", name="new_equipe")
     * Method({"GET", "POST"})
     */
    public function newE(Request $request)
    {
        $equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipe = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();
            return $this->redirectToRoute('equipe_list');
        }
        return $this->render('equipes/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/equipe/{id}", name="equipe_show")
     */
    public function show2($id)
    {
        $equipe = $this->getDoctrine()->getRepository(Equipe::class)->find($id);

        return $this->render('equipes/show.html.twig', array('equipe' => $equipe));
    }

    /**
     * @Route("/equipe/delete/{id}", name="delete_equipe")
     */
    public function delete2(Request $request, $id): Response
    {
        $c = $this->getDoctrine()
            ->getRepository(Equipe::class)
            ->find($id);
        if (!$c) {
            throw $this->createNotFoundException(
                'pas de equipe  avec id = ' . $id
            );
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($c);

        $entityManager->flush();
        return $this->redirectToRoute('equipe_list');
    }
}
