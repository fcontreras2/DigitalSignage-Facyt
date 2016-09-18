<?php
namespace DSFacyt\InfrastructureBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
    use DSFacyt\InfrastructureBundle\Form\Type\RegisterDocumentType;
use Symfony\Component\Validator\Constraints\File;


class RegisterVideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array('label' => 'Título', 'constraints' => array(new NotBlank())))
            ->add('publish_time','text',array('label' => 'Hora de publicación', 'constraints' => array(new NotBlank())))
            ->add('start_date','date',array('label' => 'Fecha inicial','widget' => 'single_text', 'format' => 'dd/MM/yyyy','constraints' => array(new NotBlank())))
            ->add('end_date','date',array('label' => 'Fecha final', 'widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'constraints' => array(new NotBlank())))
            ->add('description','text',array('label' => 'Descripción de la video', 'constraints' => array(new NotBlank())))
            ->add('Channels', 'entity', array(
                'label' => 'Canales a publicar',
                'class' => 'DSFacytDomain:Channel',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true))
             ->add( 
                $builder->create('document', 'form', 
                    array('data_class' => 'DSFacyt\InfrastructureBundle\Entity\Document', 'label' => false))
                    ->add('file', 'file', [
                        'required' => true,
                            'constraints' => [
                                new File([
                                    'maxSize' => "80M"
                                ])
                            ],
                        'label' => false
                    ])
            );
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
