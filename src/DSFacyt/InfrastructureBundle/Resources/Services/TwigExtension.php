<?php
// src/Facebook/Bundle/Twig/FacebookExtension.php
namespace DSFacyt\InfrastructureBundle\Resources\Services;

/**
 * Extension de Twig, donde se puede crear funciones y filtros de twig
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * Class TwigExtension
 * @package DSFacyt\InfrastructureBundle\Resources\Services
 */
class TwigExtension extends \Twig_Extension
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions() {
        return array(
            'hasAccess' => new \Twig_Function_Method($this, 'hasAccess')
        );
    }

    /**
     * Verifica si el usuario tiene acceso a las publicaciones
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param $module
     * @param null $permission
     * @return bool
     */
    public function hasAccess($module)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $access = $user->getAccess();
        return in_array($module, $access);
    }

    public function getName()
    {
        return 'app_extension';
    }
}