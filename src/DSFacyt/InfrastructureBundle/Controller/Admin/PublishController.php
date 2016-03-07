<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DSFacyt\Core\Application\UseCases\Admin\Publish\GetPublishStatus\GetPublishStatusCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 *
 * El siguiente controlador se encarga de recibir las peticiones respecto a las publicaciones
 * (textos, imagenes, videos)
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @package DSFacyt\InfrastructureBundle\Controller
 */
class PublishController extends Controller
{
    public function getPublishStatusAction($type, $status)
    {
        $template = null;

        switch ($type) {
            case 'text':
                $template = "@DSFacytInfrastructure/Admin/Publish/text.html.twig";
                $typeEntity = 'Text';
                break;
            case 'image':
                $template = "@DSFacytInfrastructure/Admin/Publish/image.html.twig";
                $typeEntity = 'Image';
                break;
            case 'video':
                $template = "@DSFacytInfrastructure/Admin/Publish/video.html.twig";
                $typeEntity = 'Video';
                break;
        }
        $response = ['type' => $typeEntity, 'status' =>  $status];
        $command = new GetPublishStatusCommand($typeEntity,$status);
        $response['data'] = $this->get('CommandBus')->execute($command)->getData();
        return $this->render($template,['data' => json_encode($response)]);
    }

    /**
     * Retorna las publicaciones vía Ajax
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function apiGetPublishStatusAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(),true);
            $command = new GetPublishStatusCommand(
                $data['type'],
                $data['status'],
                null,
                null,
                $data['page']
            );

            $response = $this->get('CommandBus')->execute($command);
            return new JsonResponse($response->getData(), 200);
        }

        return new JsonResponse('Error', 503);
    }
}
