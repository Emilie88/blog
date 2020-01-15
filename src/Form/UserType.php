<?php

namespace App\Form;

use App\Entity\User;
use App\Form\UserRegisterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',null,['label'=>'Votre prénom'])
            ->add('lastname',null,['label'=>'Votre nom'])
            ->add('email',EmailType::class,['label'=>'Votre email'])
            ->add('password',PasswordType::class,['label'=>'Votre mot de passe'])
            ->add('confirm_password',PasswordType::class,['label'=>'Confirmation du mot de passe'])
            // ->add("Enregister", SubmitType::class);

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

