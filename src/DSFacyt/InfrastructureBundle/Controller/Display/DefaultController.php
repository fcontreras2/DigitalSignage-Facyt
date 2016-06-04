<?php

namespace DSFacyt\InfrastructureBundle\Controller\Display;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

    public function showChannelAction($slug)
    {
        $command = new GetDataTransmitionCommand($slug);        
        $response = $this->get('CommandBus')->execute($command);

        return $this->render("DSFacytInfrastructureBundle:Display:transmition.html.twig", ['data' => json_encode($response->getData())]);
    }    
}
