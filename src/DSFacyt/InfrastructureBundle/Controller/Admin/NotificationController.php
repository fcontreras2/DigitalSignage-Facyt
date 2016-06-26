<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use DSFacyt\Core\Application\UseCases\Admin\Notification\CheckNotification\CheckNotificationCommand;

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
}
