<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DSFacyt\Core\Domain\Model\Entity\Document;
use DSFacyt\Core\Domain\Model\Entity\User;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterType;


class DefaultController extends Controller
{
    public function indexPanelAction()
    {   
        return $this->render('DSFacytInfrastructureBundle:User:index.html.twig');
    }
}
