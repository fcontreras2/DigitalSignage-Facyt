<?php 
namespace DSFacyt\InfrastructureBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;


class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',array('label' => 'Nombre', 'constraints' =>array(new NotBlank())))
            ->add('last_name', 'text', array('label' => 'Apellido', 'constraints' =>array(new NotBlank())))
            ->add('username','text',array('label' => 'Nombre de Usuario','constraints' =>array(new NotBlank())))
            ->add('email','email',array('label' => 'Correo' , 'constraints' =>array(new NotBlank())))
            ->add('indentity_card','text',array('label' => 'Cédula' , 'constraints' =>array(new NotBlank())))
            ->add('phone','text',array('label' => 'Télefono' , 'constraints' =>array(new NotBlank())))
            ->add('password','password', array('label' => 'Contraseña' , 'constraints' =>array(new NotBlank())))
            ->add('school', 'entity', array(
                'label' => 'Escuela',
                'class' => 'DSFacytDomain:School',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'property' => 'name'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {   
        $resolver->setDefaults(array(
            'data_class' => 'DSFacyt\InfrastructureBundle\Entity\User',
            'validation_groups' => array(
                'DSFacyt\InfrastructureBundle\Entity\User', 'determineValidationGroups'
            ),
        ));
    }

    public function getName()
    {
        return 'register';
    }
}
