<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Demande;
use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('matricule', TextType::class, array('label'=>'Matricule', 'attr'=>array('require'=>'require'
            ,'class'=>'form-control form-group')))

            ->add('modele', TextType::class, array('label'=>'Modele ', 'attr'=>array('require'=>'require'
            ,'class'=>'form-control form-group')))

            ->add('marque', TextType::class, array('label'=>'Marque', 'attr'=>array('require'=>'require'
            ,'class'=>'form-control form-group')))

            ->add('typeVoiture', TextType::class, array('label'=>'Type de voiture', 'attr'=>array('require'=>'require'
            ,'class'=>'form-control form-group')))

            ->add('photoVoiture', FileType::class, array('label'=>'Photo ', 'attr'=>array('require'=>'require'
            ,'class'=>'form-control form-group')))

            ->add('prix', TextType::class, array('label'=>'prix', 'attr'=>array('require'=>'require'
            ,'class'=>'form-control form-group')))

            ->add('description', TextareaType::class, array('label'=>'Description', 'attr'=>array('require'=>'require'
            ,'class'=>'form-control form-group')))

            /*->add('photoVoiture', FileType::class, [
                'label' => 'Photo',
                'attr' => array(
                    'class' => 'form-control'
                ),

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner une image',
                    ])
                ],
            ])*/
            

            ->add('users', EntityType::class, array('class'=>User::class,'label'=>'Nom user', 
           'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            /*->add('demandes', EntityType::class, array('class'=>Demande::class,'label'=>'demande de la produit', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))*/
            
            //->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group',)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
