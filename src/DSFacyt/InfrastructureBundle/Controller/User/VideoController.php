<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use DSFacyt\Core\Application\UseCases\Video\GetVideos\GetVideosCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use DSFacyt\InfrastructureBundle\Entity\Video;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterVideoType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use DSFacyt\Core\Application\UseCases\Video\UploadVideo\UploadVideoCommand;

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
    public function indexAction($page)
    {
       $command = new GetVideosCommand();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $command->setUser($user);
        $command->setPage($page);

        $response = $this->get('CommandBus')->execute($command);
        return $this->render('DSFacytInfrastructureBundle:User\Video:index.html.twig', array('data' => json_encode($response->getData())));
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

    /**
     * La siguiente función publicar un video del usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param Request $request
     * @version 03/09/2015
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function validateNewAction(Request $request)
    {
        $video = new Video();
        
        $form = $this->createForm(new RegisterVideoType(), $video);

        $form->handleRequest($request);
        dump($request);

        if ($form->isValid()) {

            $user = $security = $this->container->get('security.context')->getToken()->getUser();
            $video->setUser($user);
            $command = new UploadVideoCommand($video, $user->getIndentityCard());
            $this->get('CommandBus')->execute($command);

            $validator = $this->get('validator');
            $errors = $validator->validate($video);

            if (count($errors) > 0) {
                return $this->render('DSFacytInfrastructureBundle:User\Image:newImage.html.twig', array('form' => $form->createView(), 'errors' => $erros));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('ds_facyt_infrastructure_user_video_homepage');
        }

        return $this->render('DSFacytInfrastructureBundle:User\Video:newVideo.html.twig', array('form' => $form->createView(), 'data' => json_encode(['pathImage' => null])));

    }

}
