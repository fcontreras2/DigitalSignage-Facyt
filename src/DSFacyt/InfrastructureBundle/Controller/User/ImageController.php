<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class ImageController extends Controller
{
    public function indexAction()
    {
        return new Response("Repuesta prueba - Image");
        //return $this->render('DSFacytInfrastructureBundle:User:index.html.twig');
    }
}
