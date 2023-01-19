<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Contrat;
use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('numeroContrat', TextType::class, array('label'=>'Numéro', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('dateDebut', DateType::class, array('label'=>"Date debut",  
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            


            ->add('dateFin', DateType::class, array('label'=>"Date de fin", 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            
            ->add('montant', NumberType::class, array('label'=>'Montant', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('typeContrat', TextType::class, array('label'=>'Type Contrat', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('voitures', EntityType::class, array('class'=>Voiture::class,'label'=>'Voiture ', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('dateContrat', DateType::class, array('label'=>"Date contrat", 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('users', EntityType::class, array('class'=>User::class,'label'=>'Nom', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group',)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
