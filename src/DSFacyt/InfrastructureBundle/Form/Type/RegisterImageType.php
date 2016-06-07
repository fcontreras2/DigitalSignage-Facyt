<?php
namespace DSFacyt\InfrastructureBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterDocumentType;

class RegisterImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array('label' => 'Título'))
            ->add('publish_time','text',array('label' => 'Hora de publicación'))
            ->add('start_date','date',array('label' => 'Fecha inicial','widget' => 'single_text', 'format' => 'dd/MM/yyyy'))
            ->add('end_date','date',array('label' => 'Fecha final', 'widget' => 'single_text', 'format' => 'dd/MM/yyyy'))
            ->add('description','text',array('label' => 'Descripción de la imagen'))
            ->add('Channels', 'entity', array(
                'label' => 'Canales a publicar',
                'class' => 'DSFacytDomain:Channel',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true))
            ->add( 
                $builder->create('document', 'form', 
                    array('data_class' => 'DSFacyt\InfrastructureBundle\Entity\Document', 'label' => false))
                    ->add('file', 'file', array('label' => false))
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DSFacyt\InfrastructureBundle\Entity\Image',
            'validation_groups' => array(
                'DSFacyt\InfrastructureBundle\Entity\Image', 'determineValidationGroups'
            ),
        ));
    }

    public function getName()
    {
        return 'registerImage';
    }
}
