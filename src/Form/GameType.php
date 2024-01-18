<?php

namespace App\Form;
use App\Entity\Game;
use App\Entity\Category;
use App\Entity\Equipe;
use App\Entity\Joueur;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('datedumatch')
        ->add('stade')
        ->add('category',EntityType::class,['class' => Category::class,
                                        'choice_label' => 'nomcategory'])       
        ->add('ville')
        ->add('equipe1',EntityType::class,['class' => Equipe::class,
                                        'choice_label' => 'nome'])  
                                        ->add('score1')

         ->add('equipe2',EntityType::class,['class' => Equipe::class,
                                        'choice_label' => 'nome'])  
                                        ->add('score2')

        ->add('lien');
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
