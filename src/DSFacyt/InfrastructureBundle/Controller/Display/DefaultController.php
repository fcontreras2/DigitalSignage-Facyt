<?php

namespace DSFacyt\InfrastructureBundle\Controller\Display;

use DSFacyt\Core\Application\UseCases\Display\CheckPublish\CheckPublishCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use DSFacyt\Core\Application\UseCases\Display\GetDataTransmition\GetDataTransmitionCommand;
use DSFacyt\Core\Application\UseCases\GetChannels\GetChannelsCommand;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $command = new GetChannelsCommand();
        $response = $this->get('CommandBus')->execute($command);
        return $this->render('@DSFacytInfrastructure/Display/index.html.twig',['data' => $response->getData()]);
    }

    public function showChannelAction($slug, Request $request)
    {
        $command = new GetDataTransmitionCommand($slug);        
        $response = $this->get('CommandBus')->execute($command);

        return $this->render("DSFacytInfrastructureBundle:Display:transmition.html.twig", ['data' => json_encode($response->getData())]);
    }

    public function checkPublishAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(),true);
            $command = new CheckPublishCommand($data['slug']);
            $response = $this->get('CommandBus')->execute($command);

            return new JsonResponse($response->getData(), $response->getStatusCode());
        }
        return new JsonResponse(404,'Bad Request');
    }
}
