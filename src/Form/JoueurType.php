<?php

namespace App\Form;
use App\Entity\Equipe;
use App\Entity\Joueur;
use App\Entity\Category;
use App\Entity\Image;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class JoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom')
        ->add('datedenaissance')
        ->add('datefin')
        ->add('pied')
        ->add('image', EntityType::class, [
            'class' => Image::class,
            'choice_label' => 'url',
        ])
        ->add('category',EntityType::class,['class' => Category::class,
        'choice_label' => 'nomcategory'])         
        ->add('poste')
        ->add('nationalite')
        ->add('agent')
        ->add('equipe',EntityType::class,['class' => Equipe::class,
                                        'choice_label' => 'nome']);
}
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joueur::class,
        ]);
    }
}
