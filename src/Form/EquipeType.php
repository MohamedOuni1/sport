<?php

namespace App\Form;
use App\Entity\Equipe;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nome', null, [
            'label' => 'Nom', // Ajouter le label pour le champ 'nome'
        ])
        ->add('pays', null, [
            'label' => 'Pays', // Ajouter le label pour le champ 'pays'
        ])
        ->add('division', null, [
            'label' => 'Division', // Ajouter le label pour le champ 'division'
        ]);


}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
