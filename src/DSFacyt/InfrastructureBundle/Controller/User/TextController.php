<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class TextController extends Controller
{
    public function indexAction()
    {
        return new Response("Repuesta prueba - Texto");
        //return $this->render('DSFacytInfrastructureBundle:User:index.html.twig');
    }
}
