<?php

namespace App\Form;
use App\Entity\Equipe;
use App\Entity\Classement;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ClassementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nbrm')
        ->add('nbrmg')
        ->add('nbrmp')
        ->add('nbrmn')

        ->add('equipe',EntityType::class,['class' => Equipe::class,
                                        'choice_label' => 'nome']);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classement::class,
        ]);
    }
}
