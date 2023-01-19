<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Demande;
use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('numeroDemande', TextType::class, array('label'=>'Numéro', 
        'attr'=>array('require'=>'require','class'=>'form-control form-group')))

        ->add('infoDemande', TextareaType::class, array('label'=>'Informations',
        'attr'=>array('require'=>'require','class'=>'form-control form-group')))

        ->add('voitures', EntityType::class, array('class'=>Voiture::class,'label'=>'Voiture', 
        'attr'=>array('require'=>'require','class'=>'form-control form-group')))

        ->add('dateDemande', DateType::class, array('label'=>"Date demande", 
        'attr'=>array('require'=>'require','class'=>'form-control form-group')))

        ->add('users', EntityType::class, array('class'=>User::class,'label'=>'Nom', 
        'attr'=>array('require'=>'require','class'=>'form-control form-group')))

        ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group',)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
