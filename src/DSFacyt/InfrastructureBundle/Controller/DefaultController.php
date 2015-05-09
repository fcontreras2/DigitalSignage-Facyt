<?php

namespace DSFacyt\InfrastructureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DSFacytInfrastructureBundle:Default:index.html.twig', array('name' => $name));
    }
}
