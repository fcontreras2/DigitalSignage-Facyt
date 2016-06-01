<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use DSFacyt\InfrastructureBundle\Entity\Video;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterVideoType;

/**
 * Class VideoController
 *
 * El siguiente Controlador se encarga de recibir y procesar las solicitudes referentes a las publicaciones
 * de tipo Video de los usuarios
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31/08/2015
 * @package DSFacyt\InfrastructureBundle\Controller\User
 */
class VideoController extends Controller
{
    /**
     * La siguiente funcion se encarga de rendeficar a la vista de las Videos del usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31/08/2015
     * @return Response
     */
    public function indexAction()
    {
/*        $command = new GetVideosCommand();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $command->setUser($user);
        $command->setPage($page);

        $response = $this->get('CommandBus')->execute($command);
        return $this->render('DSFacytInfrastructureBundle:User\Video:index.html.twig', array('data' => json_encode($response->getData())));*/
        return $this->render('DSFacytInfrastructureBundle:User\Video:index.html.twig',['data'=> json_encode(['videos' => []])]);
    }

    /**
     * La siguiente Función se encarga de mostrar el formulario de
     * las pubicaciones nuevas de tipo videoo
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 02/09/2015
     * @return Response
     */
    public function publishNewAction()
    {
        $video= new Video();
        $form = $this->createForm(new RegisterVideoType(), $video,
            array(
                'action' => $this->generateUrl('ds_facyt_infrastructure_user_video_new_validate'),
                'method' => 'POST'));

        return $this->render('DSFacytInfrastructureBundle:User\Video:newVideo.html.twig', array('form' => $form->createView(),'data' => json_encode(['pathImage' => null])));
    }
}
