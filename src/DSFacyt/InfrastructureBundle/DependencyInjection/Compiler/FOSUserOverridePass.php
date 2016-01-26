<?php
namespace DSFacyt\InfrastructureBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
* La clase de encarga de el procesod e autentificación de un usuario al registrarse
* 
* @author Freddy Coontreras <freddycontreras3@gmail.com>
*/
class FOSUserOverridePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition('fos_user.listener.authentication')->setClass('DSFacyt\InfrastructureBundle\EventListener\AuthenticationListener');
    }
}