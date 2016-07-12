<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use DSFacyt\Core\Application\UseCases\Admin\Groups\GetGroups\GetGroupsCommand;

/**
 * Group controller.
 *
 */
class GroupController extends Controller
{

    public function indexAction()
    {
        $command = new GetGroupsCommand();
        $response = $this->get('CommandBus')->execute($command);
        return $this->render('DSFacytInfrastructureBundle:Admin/Group:index.html.twig',['data' => json_encode($response->getData())]);
    }
}
