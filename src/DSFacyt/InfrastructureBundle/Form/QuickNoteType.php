<?php

namespace DSFacyt\InfrastructureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuickNoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',['label' => 'Título'])
            ->add('info','text', ['label' => 'información'])
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
            'data_class' => 'DSFacyt\InfrastructureBundle\Entity\QuickNote'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dsfacyt_infrastructurebundle_quicknote';
    }
}
