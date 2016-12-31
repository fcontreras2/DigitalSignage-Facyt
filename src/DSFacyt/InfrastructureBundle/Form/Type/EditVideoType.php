<?php
namespace DSFacyt\InfrastructureBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;

class EditVideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array('label' => 'Título', 'constraints' => array(new NotBlank())))
            ->add('publish_time','text',array('label' => 'Hora de publicación', 'constraints' => array(new NotBlank())))
            ->add('start_date','date',array('label' => 'Fecha inicial','widget' => 'single_text', 'format' => 'dd/MM/yyyy','constraints' => array(new NotBlank())))
            ->add('end_date','date',array('label' => 'Fecha final', 'widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'constraints' => array(new NotBlank())))
            ->add('description','text',array('label' => 'Descripción de la video', 'constraints' => array(new NotBlank())))
             ->add('status', 'choice', array('label' => 'Estado',
    'choices'  => array(
        0 => 'Nuevo',
        1 => 'Aceptada',
        2 => 'Activa',
        3 => 'Finalizada',
        4 => 'Cancelada'        
        )))
            ->add('Channels', 'entity', array(
                'label' => 'Canales a publicar',
                'class' => 'DSFacytDomain:Channel',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DSFacyt\InfrastructureBundle\Entity\Video',
            'validation_groups' => array(
                'DSFacyt\InfrastructureBundle\Entity\Video', 'determineValidationGroups'
            ),
        ));
    }

    public function getName()
    {
        return 'registerVideo';
    }
}
