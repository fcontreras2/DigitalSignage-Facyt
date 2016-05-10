<?php

namespace DSFacyt\InfrastructureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChannelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',['label' => 'Nombre'])
            ->add('description','textarea',['label' => 'Descripción'])
            ->add('status', 'choice',
                [   'label' => 'Estado',
                    'choices' => [
                    1 => 'Activo', 0 => 'Inactivo'
            ]])

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DSFacyt\InfrastructureBundle\Entity\Channel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dsfacyt_infrastructurebundle_channel';
    }
}
