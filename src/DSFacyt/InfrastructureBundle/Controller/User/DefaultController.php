<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use DSFacyt\Core\Application\UseCases\User\EditProfile\EditProfileCommand;
use DSFacyt\Core\Application\UseCases\User\GetProfile\GetProfileCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use DSFacyt\Core\Application\UseCases\User\BasicInformation\BasicInformationCommand;

/**
 * Class DefaultController
 *
 * El siguiente controlador se declaran todas las funciones o funcionalidades
 * que no tienen un lógica de negocio en la sesión del usuario
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31/08/2015
 * @package DSFacyt\InfrastructureBundle\Controller\User
 */
class DefaultController extends Controller
{
    /**
     * La siguiente funcion se encarga de rendificar la vista del home del usuario (panel)
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31/08/2015
     * @return Response
     */
    public function indexPanelAction()
    {
        $command = new BasicInformationCommand();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $command->setUser($user);

        $response = $this->get('CommandBus')->execute($command);

        return $this->render('DSFacytInfrastructureBundle:User:index.html.twig',
            array('data' => $response->getData()));
    }

    /**
     * La siguiente funciton retorna los datos de un usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 02/02/2016
     * @return Response
     */
    public function getProfileAction()
    {
        $command = new GetProfileCommand();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $command->setUser($user);

        $response = $this->get('CommandBus')->execute($command);

        return $this->render('DSFacytInfrastructureBundle:User:profile.html.twig',
            array('data' => json_encode($response->getData())));
    }

    /**
     * La siguiente función recibe los datos de editar un usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param Request $request
     * @version 12/02/2016
     *
     * @return JsonResponse
     */
    public function editProfileAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $data = json_decode($request->getContent(),true);

            $command = new EditProfileCommand();
            $command->setUser($this->get('security.token_storage')->getToken()->getUser());
            $command->setData($data);

            $response = $this->get('CommandBus')->execute($command);

            if ($response->getStatusCode() == 200)
                return new JsonResponse(null,200);
            else
                return new JsonResponse($response->getMessage(),$response->getStatusCode());


        }

        return new JsonResponse(null,400);
    }
}
