<?php

namespace App\Form;
use App\Entity\Stat;
use App\Entity\Game;
use App\Entity\Joueur;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('joueur',EntityType::class,['class' => Joueur::class,
        'choice_label' => 'nom'])   

        ->add('game',EntityType::class,['class' => Game::class,
        'choice_label' => 'equipe2'])   

        ->add('minutejoue')
        ->add('but')
        ->add('assist')
        ->add('cartonjaune')
        ->add('cartonrouge')
        ->add('note')
        ->add('lien')

    

             ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stat::class,
        ]);
    }
}
