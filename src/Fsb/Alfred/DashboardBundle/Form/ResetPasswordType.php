<?php

namespace Fsb\Alfred\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResetPasswordType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', 'repeated', array('type' => 'password', 'invalid_message' => 'Les mots de passe ne correspondent pas.', 'options' => array('required' => true), 'first_options' => array('label' => 'Mot de passe'), 'second_options' => array('label' => 'Vérification du mot de passe')))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fsb_alfred_dashboard_reset_password_type';
    }
}
