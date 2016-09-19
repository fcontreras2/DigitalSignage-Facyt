<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use DSFacyt\Core\Application\UseCases\Admin\Groups\GetGroups\GetGroupsCommand;
use DSFacyt\Core\Application\UseCases\Admin\Groups\EditGroup\EditGroupCommand;
use DSFacyt\InfrastructureBundle\Entity\Group;

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

    public function editAction($group_id, Request $request)
    {
    	if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(),true);
            $command = new EditGroupCommand(
                $group_id,
                $data                
            );

            $response = $this->get('CommandBus')->execute($command);

            return new JsonResponse($response->getMessage(), $response->getStatusCode());
        }

    	return new JsonResponse(null, 400);
    }


    public function newGroupAction(Request $request)
    {
    	if ($request->isXmlHttpRequest()) {
    		$name = json_decode($request->getContent(),true)['name'];
    		
    		try {
	    		$manager = $this->container->get('doctrine.orm.entity_manager');
	        	$group = new Group();
	        	$group->setName($name);

	        	$manager->persist($group);
	        	$manager->flush();
                return new JsonResponse(null, 200);
        	} catch (\Exception $e) {
        		return new JsonResponse(null, 500);
        	}
    	}

		return new JsonResponse(null, 400);
    }
}
