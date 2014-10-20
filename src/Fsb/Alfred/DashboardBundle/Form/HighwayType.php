<?php

namespace Fsb\Alfred\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HighwayType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('journey', 'text', array('label' => 'Trajet', 'required' => false, 'attr' => array('placeholder' => 'Domicile - Travail')))
            ->add('price', 'number', array('label' => 'Prix', 'required' => true, 'attr' => array('placeholder' => '10.00')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fsb\Alfred\CoreBundle\Entity\Highway'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fsb_alfred_dashboard_highway_type';
    }
}
