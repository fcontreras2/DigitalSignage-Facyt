<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use DSFacyt\Core\Application\UseCases\Admin\Notification\GetNotifications\GetNotificationsCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use DSFacyt\Core\Application\UseCases\Admin\Notification\CheckNotification\CheckNotificationCommand;
use Symfony\Component\HttpFoundation\Response;

/**
 * Nofitication controller.
 *
 */
class NotificationController extends Controller
{
    public function checkAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $command = new CheckNotificationCommand();
            $response = $this->get('CommandBus')->execute($command);
            return new JsonResponse($response->getData(),$response->getStatusCode());
        }

        return new JsonResponse('Bad Request', 400);
    }

    public function indexAction()
    {
        $command = new GetNotificationsCommand();
        $response = $this->get('CommandBus')->execute($command);
        return $this->render('DSFacytInfrastructureBundle:Admin/Notification:index.html.twig',
            ['data' => json_encode($response->getData())]);
    }

    public function apiGetNotificationsAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            
            $data = json_decode($request->getContent(),true);
            
            $command = new GetNotificationsCommand($data['page']);
            $response = $this->get('CommandBus')->execute($command);
            return new JsonResponse($response->getData(), $response->getStatusCode());
        }

        return new JsonResponse('Error', 503);
    }
}
