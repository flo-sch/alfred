<?php

namespace Fsb\Alfred\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubscriptionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array('label' => 'Adresse e-mail', 'required' => true))
            ->add('password', 'password', array('label' => 'Mot de passe', 'required' => true))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fsb\Alfred\CoreBundle\Entity\Driver'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fsb_alfred_dashboard_subscription_type';
    }
}
