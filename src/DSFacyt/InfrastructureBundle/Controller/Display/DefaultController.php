<?php

namespace DSFacyt\InfrastructureBundle\Controller\Display;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@DSFacytInfrastructure/Display/index.html.twig');
    }
}
