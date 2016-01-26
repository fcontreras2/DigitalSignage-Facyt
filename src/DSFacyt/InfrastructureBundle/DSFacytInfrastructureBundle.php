<?php

namespace DSFacyt\InfrastructureBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use DSFacyt\InfrastructureBundle\DependencyInjection\Compiler\FOSUserOverridePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DSFacytInfrastructureBundle extends Bundle
{
	public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FOSUserOverridePass());
    }

	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
