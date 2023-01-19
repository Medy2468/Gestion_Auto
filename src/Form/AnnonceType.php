<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BooleanType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('typeAnnonce', TextType::class, array('label'=>'Type annonce',  
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('infoAnnonce', TextareaType::class, array('label'=>'Description',  
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            /*->add('status', BooleanType::class, array('label'=>'Status',  
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))*/

            ->add('prix', TextType::class, array('label'=>'Prix',  
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('photoAnnonce', FileType::class, array('label'=>'Photo ', 'attr'=>array('require'=>'require'
            ,'class'=>'form-control form-group')))

            /*->add('voitures', EntityType::class, array('class'=>Voiture::class, 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))*/
            
            //->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group',)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
