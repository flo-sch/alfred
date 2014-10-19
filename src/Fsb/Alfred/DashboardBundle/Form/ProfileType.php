<?php

namespace Fsb\Alfred\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => 'Utilisateur', 'required' => true))
            ->add('email', 'email', array('label' => 'Adresse e-mail', 'required' => true))
            ->add('carName', 'text', array('label' => 'Nom de voiture', 'required' => true))
            ->add('color', 'text', array('label' => 'Couleur', 'required' => false, 'attr' => array('class' => 'colorpicker')))
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
        return 'fsb_alfred_dashboard_profile_type';
    }
}
