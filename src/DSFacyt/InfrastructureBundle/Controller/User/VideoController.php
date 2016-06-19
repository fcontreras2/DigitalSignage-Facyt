<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use DSFacyt\Core\Application\UseCases\Video\GetVideos\GetVideosCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use DSFacyt\InfrastructureBundle\Entity\Video;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterVideoType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use DSFacyt\Core\Application\UseCases\Video\UploadVideo\UploadVideoCommand;
use DSFacyt\Core\Application\UseCases\Video\EditVideo\EditVideoCommand;
use DSFacyt\Core\Application\UseCases\Video\SetVideo\SetVideoCommand;

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

        if ($form->isValid()) {

            $user = $security = $this->container->get('security.context')->getToken()->getUser();
            $video->setUser($user);
            $command = new UploadVideoCommand($video, $user->getIndentityCard());
            $this->get('CommandBus')->execute($command);

            $validator = $this->get('validator');
            $errors = $validator->validate($video);

            if (count($errors) > 0) {
                return $this->render('DSFacytInfrastructureBundle:User\Video:newVideo.html.twig', array('form' => $form->createView(), 'errors' => $erros));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('ds_facyt_infrastructure_user_video_homepage');
        }

        return $this->render('DSFacytInfrastructureBundle:User\Video:newVideo.html.twig', array('form' => $form->createView(), 'data' => json_encode(['pathVideo' => null])));

    }

    public function editAction($videoId)
    {
        $command = new EditVideoCommand();
        $command->setVideoId($videoId);
        $response = $this->get('CommandBus')->execute($command);
        if ($response->getStatusCode() == 201) {
            $form = $this->createForm(new RegisterVideoType(), $command->getEntityVideo(),
                array(
                    'action' => $this->generateUrl('ds_facyt_infrastructure_user_video_edit_validate',array('videoId' => $videoId)),
                    'method' => 'POST'));
            $pathVideo = $command->getEntityVideo()->getDocument()->getFileName();
            return $this->render('DSFacytInfrastructureBundle:User\Video:newVideo.html.twig', array('form' => $form->createView(), 'data' => json_encode(['pathVideo' => $pathVideo])));
        }

        return $this->redirect('ds_facyt_infrastructure_user_video_homepage');
    }

        /**
     * La siguiente función se encarga de mostrar el formulario de validar y persistir los datos
     * del formulario de editar los datos del texto
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param integer $textId
     * @param Request $request
     * @version 30/09/2015
     * @return Response
     */
    public function validateEditAction($videoId, Request $request)
    {
        if (!$videoId) {
            throw $this->createNotFoundException('Hubo un error a enviar el formulario');
        }

        $command = new EditVideoCommand();
        $command->setVideoId($videoId);
        $this->get('CommandBus')->execute($command);
        $form = $this->createForm(new RegisterVideoType(), $command->getEntityVideo(),
            array(
                'action' => $this->generateUrl('ds_facyt_infrastructure_user_video_edit_validate',array('videoId' => $videoId)),
                'method' => 'POST'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $video = $command->getEntityVideo();
            $video->setStatus(0);

            $validator = $this->get('validator');
            $errors = $validator->validate($video);

            if (count($errors) > 0) {
                return $this->render('DSFacytInfrastructureBundle:User\Video:newVideo.html.twig', array('form' => $form->createView(), 'errors' => $erros,'data' => json_encode(['pathVideo' => $pathVideo])));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('ds_facyt_infrastructure_user_video_homepage');
        }

        return $this->render('DSFacytInfrastructureBundle:User\Video:newVideo.html.twig', array('form' => $form->createView(), 'data' => json_encode(['pathVideo' => null])));
    }

    /**
    * La función se encarga de crear y editar
    * una publicación de tipo video vía ajax
    *
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @param Request $request
    **/
    public function setVideoAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {

            $data = json_decode($request->request->get('data'), true);

            if ($request->files->get('file')) {
                $file = new File($request->files->get('file'));
                var_dump($file);
            }

            die(var_dump($data));
            /*if ($request->files->get('file')) 
                $file = new File($request->files->get('file'));

            $user = $security = $this->container->get('security.context')->getToken()->getUser();
            $command = new SetVideoCommand($file,$data, $user);
            $response = $this->get('CommandBus')->execute($command);

            return new JsonResponse($response->getMessage(), $response->getStatusCode());*/

        }

        return new JsonResponse('Bad Request', 400);
    }
}
