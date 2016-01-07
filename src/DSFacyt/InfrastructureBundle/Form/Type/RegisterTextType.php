<?php
namespace DSFacyt\InfrastructureBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterTextType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array('label' => 'Título', 'constraints' => array(new NotBlank())))
            ->add('publish_time','text',array('label' => 'Hora de publicación', 'constraints' => array(new NotBlank()),'attr' => array('id' => 'timepicker1')))
            ->add('start_date','date',array('label' => 'Fecha inicial','widget' => 'single_text', 'format' => 'dd/MM/yyyy','constraints' => array(new NotBlank())))
            ->add('end_date','date',array('label' => 'Fecha final', 'widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'constraints' => array(new NotBlank())))
            ->add('info','textarea',array('label' => 'Información a publicar', 'constraints' => array(new NotBlank())))
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
            'data_class' => 'DSFacyt\Core\Domain\Model\Entity\Text',
            'validation_groups' => array(
                'DSFacyt\Core\Domain\Model\Entity\Text', 'determineValidationGroups'
            ),
        ));
    }

    public function getName()
    {
        return 'registerText';
    }
}
