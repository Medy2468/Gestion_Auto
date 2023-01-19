<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Roles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, array('label'=>'Nom ', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('prenom', TextType::class, array('label'=>'Prenom', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('email', TextType::class, array('label'=>'Email', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('password', PasswordType::class, array('label'=>'Mot de passe', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('tel', TextType::class, array('label'=>'Telephone', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('cni', TextType::class, array('label'=>'Cni',  
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('adresse', TextType::class, array('label'=>'Adresse', 
            'attr'=>array('require'=>'require','class'=>'form-control form-group')))

            ->add('roles', EntityType::class, array('class'=>Roles::class,'label'=>'Role', 
             'attr'=>array('require'=>'require','class'=>'form-control form-group')))
        

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter termes',
                'attr' => array(
                    'class' => 'forget-pwd mt-2'
                ),
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les termes.',
                    ]),
                ],
            ])

            

            /*->add('demandes', EntityType::class, array('class'=>Demande::class,
            'label'=>'Demande', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))*/

            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group',)))
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
