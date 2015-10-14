<?php
namespace DSFacyt\InfrastructureBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', array('label' => 'Nombre del Documento'))   
            ->add('file','file', array('label' => 'Archivo'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DSFacyt\Core\Domain\Model\Entity\Document',
            'validation_groups' => array(
                'DSFacyt\Core\Domain\Model\Entity\Document', 'determineValidationGroups'
            ),
        ));
    }

    public function getName()
    {
        return 'registerDocument';
    }
}
