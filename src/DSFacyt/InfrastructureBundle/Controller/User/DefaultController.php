<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        return $this->render('DSFacytInfrastructureBundle:User:index.html.twig', array('data' => $response->getData()));
    }
}
