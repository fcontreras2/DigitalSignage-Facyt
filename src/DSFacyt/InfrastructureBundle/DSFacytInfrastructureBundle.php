<?php

namespace DSFacyt\InfrastructureBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DSFacytInfrastructureBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
