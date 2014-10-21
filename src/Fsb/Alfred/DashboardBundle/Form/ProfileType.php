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
            ->add('wouldManageGasoil', 'checkbox', array('label' => 'Gestion du carburant ?', 'required' => false))
            ->add('wouldManageHighway', 'checkbox', array('label' => 'Gestion des trajets autoroutiers ?', 'required' => false))
            ->add('wouldManageInsuranceFee', 'checkbox', array('label' => 'Gestion des contrats d\'assurance ?', 'required' => false))
            ->add('wouldManageReparations', 'checkbox', array('label' => 'Gestion des réparations ?', 'required' => false))
            ->add('initialKilometers', 'integer', array('label' => 'Kilomètrage initial', 'required' => false))
            ->add('currentKilometers', 'integer', array('label' => 'Kilomètrage actuel', 'required' => false))
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
