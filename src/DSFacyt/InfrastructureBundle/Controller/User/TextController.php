<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use DSFacyt\Core\Application\UseCases\Text\GetTexts\GetTextsCommand;

/**
 * Class TextController
 *
 * El siguiente Controlador se encarga de recibir y procesar las solicitudes referentes a las publicaciones
 * de tipo Textos de los usuarios
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31/08/2015
 * @package DSFacyt\InfrastructureBundle\Controller\User
 */
class TextController extends Controller
{
    /**
     * La siguiente funcion se encarga de rendeficar a la vista de las Textos del usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31/08/2015
     * @return Response
     */
    public function indexAction()
    {
        $command = new GetTextsCommand();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $command->setUser($user);

        $response = $this->get('CommandBus')->execute($command);

        return $this->render('DSFacytInfrastructureBundle:User\Text:index.html.twig', array('data' => json_encode($response->getData())));
    }
}
