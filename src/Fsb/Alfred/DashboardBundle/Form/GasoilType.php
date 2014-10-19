<?php

namespace Fsb\Alfred\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GasoilType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('capacity', 'integer', array('label' => 'Capacité en litres', 'required' => false))
            ->add('price', 'number', array('label' => 'Prix au litre', 'required' => false))
            ->add('kilometers', 'integer', array('label' => 'Kilométrage', 'required' => false))
            ->add('company', 'text', array('label' => 'Compagnie', 'required' => false))
            ->add('place', 'text', array('label' => 'Lieu', 'required' => false))
            ->add('latitude', 'number', array('label' => 'Latitude', 'required' => false))
            ->add('longitude', 'number', array('label' => 'Longitude', 'required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fsb\Alfred\CoreBundle\Entity\Gasoil'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fsb_alfred_dashboard_gasoil_type';
    }
}
