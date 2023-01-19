<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Voiture;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('dateDebut', DateType::class, array('label'=>"Date de debut", 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('dateFin', DateType::class, array('label'=>"Date de fin", 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('voitures', EntityType::class, array('class'=>Voiture::class, 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('users', EntityType::class, array('class'=>User::class,'label'=>'Nom', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group',)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
