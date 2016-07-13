<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

/**
 * Configuraciones del sistema controller.
 */
class ConfigController extends Controller
{
    public function indexAction()
    {
        $configService = $this->get('ConfigurationDSFacyt');
        return $this->render('DSFacytInfrastructureBundle:Admin/Config:index.html.twig', ['data' => json_encode($configService->getConfig())]);
    }
}
