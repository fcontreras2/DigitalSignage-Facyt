<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    public function updateConfigAction(Request $request)
    {
    	if ($request->isXmlHttpRequest()) {
    		try {
    		    $data = json_decode($request->getContent(),true);
    		    $configService = $this->get('ConfigurationDSFacyt');
    		    $configService->updateConfig($data);
    		
    			return new JsonResponse(null,200);
    		} catch (\Exception $e) {
    			return new JsonResponse($e->getMessage(),500);
    		}
    	}

    	return new JsonResponse(404);
    }
}
