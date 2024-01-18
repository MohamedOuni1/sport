<?php
namespace App\Controller;
use App\Entity\Game;
use App\Entity\Stat;
use App\Entity\Joueur;
use App\Form\StatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Annotation\Route ;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class GStat extends AbstractController
{
    #[Route('/home9', name: 'stat_list')]
    public function home4()
    {
        $stats = $this->getDoctrine()->getRepository(Stat::class)->findAll();
        return $this->render('stats/index.html.twig', ['stats' => $stats]);
    }


/**
      * @Route("/stat/{joueurID}", name="new_stat")
       * Method({"GET", "POST"})*/ 
      public function newstat(Request $request , $joueurID ) {
        $stat = new Stat();
      $form = $this->createForm(StatType::class,$stat);
        $form = $this->createFormBuilder($stat)
  
          ->add('minutejoue', NumberType::class,[
            'label' => 'Nombre minutes' ]) 
          
          ->add('but', NumberType::class,[
            'label' => 'Nombre but marquée' ]) 
          ->add('assist', NumberType::class
          ,[
            'label' => 'Nombre de passe  décissif' ]) 
          ->add('cartonjaune', ChoiceType::class, [
            'label' => 'Carton Jaune' ,
            'choices' => [
                '0' => '0',
                '1' => '1',
                '2' => '2',

            ],
        ])
                  
        
        ->add('cartonrouge', ChoiceType::class
          ,[
            'label' => 'Carton Rouge' ,
            'choices' => [
                '0' => '0',
                '1' => '1',
            ],
        ])

        ->add('note', NumberType::class,[
          'label' => 'Note sur le rendement ' ]) 

          ->add('game',EntityType::class,['class' => Game::class,
          'choice_label' => 'id'])

          ->add('lien', TextType::class)

  
            ->getForm(); 
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
              $em = $this->getDoctrine()->getManager();
              $joueur = $em->getRepository(Joueur::class)->find($joueurID);
              $stat->setJoueur($joueur);
      
              $em->persist($stat);
              $em->flush();



              return $this->redirectToRoute('stat_list');
            }
            return $this->render('stats/ajoutspec.html.twig',['form' => $form->createView()]);
        }


         /**
      * @Route("/stats/", name="new_stats")
       * Method({"GET", "POST"})*/ 
      public function newstats(Request $request ) {
        $stat = new Stat();
        $form = $this->createFormBuilder($stat)
        ->add('joueur',EntityType::class,['class' => Joueur::class,
        'choice_label' => 'nom']) 

          ->add('minutejoue', NumberType::class,[
            'label' => 'Nombre minutes' ]) 
          
          ->add('but', NumberType::class,[
            'label' => 'Nombre but marquée' ]) 
          ->add('assist', NumberType::class
          ,[
            'label' => 'Nombre de passe  décissif' ]) 
          ->add('cartonjaune', ChoiceType::class, [
            'label' => 'Carton Jaune' ,
            'choices' => [
                '0' => '0',
                '1' => '1',
                '2' => '2',

            ],
        ])
                  
        
        ->add('cartonrouge', ChoiceType::class
          ,[
            'label' => 'Carton Rouge' ,
            'choices' => [
                '0' => '0',
                '1' => '1',
            ],
        ])

        ->add('note', NumberType::class,[
          'label' => 'Note sur le rendement ' ]) 

          ->add('game',EntityType::class,['class' => Game::class,
          'choice_label' => 'id'])

          ->add('lien', TextType::class)

  
            ->getForm(); 
            $form->handleRequest($request);
           
              if($form->isSubmitted() && $form->isValid()) {
                $stat = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($stat);
                $entityManager->flush();    


              return $this->redirectToRoute('stat_list');
            }
            return $this->render('stats/ajout.html.twig',['form' => $form->createView()]);
        }


  




/**
 * @Route("/joueur/stats/{joueurId}", name="joueur_stats")
     */
    public function showPlayerStats($joueurId)
    {
        $joueur = $this->getDoctrine()
            ->getRepository(Joueur::class)
            ->find($joueurId);

        if (!$joueur) {
            throw $this->createNotFoundException('No joueur found for id '.$joueurId);
        }


        $stats = $joueur->getStats(); 

        return $this->render('stats/indexspec.html.twig', [
            'joueur' => $joueur,
            'stats' => $stats,
        ]);
    }


}