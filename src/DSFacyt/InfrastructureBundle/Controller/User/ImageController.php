<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use DSFacyt\Core\Application\UseCases\Image\EditImage\EditImageCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;

use DSFacyt\InfrastructureBundle\Form\Type\RegisterImageType;
use DSFacyt\InfrastructureBundle\Entity\Image;
use DSFacyt\InfrastructureBundle\Entity\Document;

use DSFacyt\Core\Application\UseCases\Image\UploadImage\UploadImageCommand;
use DSFacyt\Core\Application\UseCases\Image\SetImage\SetImageCommand;
use DSFacyt\Core\Application\UseCases\Image\GetImages\GetImagesCommand;
use DSFacyt\Core\Application\UseCases\Image\GetImage\GetImageCommand;
use DSFacyt\Core\Application\UseCases\Image\DeleteImage\DeleteImageCommand;


/**
 * Class ImageController
 *
 * El siguiente Controlador se encarga de recibir y procesar las solicitudes referentes a las publicaciones
 * de tipo Imagenes de los usuarios
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31/08/2015
 * @package DSFacyt\InfrastructureBundle\Controller\User
 */
class ImageController extends Controller
{
    /**
     * La siguiente funcion se encarga de rendeficar a la vista de las Imagenes del usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
     * @param integer $page
     * @version 31/08/2015
     * @return Response
     */
    public function indexAction($page)
    {
        $command = new GetImagesCommand();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $command->setUser($user);
        $command->setPage($page);

        $response = $this->get('CommandBus')->execute($command);
        return $this->render('DSFacytInfrastructureBundle:User\Image:index.html.twig', array('data' => json_encode($response->getData())));
    }

    /**
     * La siguiente Función se encarga de mostrar el formulario de
     * las pubicaciones nuevas de tipo imageo
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 02/09/2015
     * @return Response
     */
    public function publishNewAction()
    {

        $data = ['channels' => []];
        $manager = $this->container->get('doctrine.orm.entity_manager');

        $channels = $manager->getRepository('DSFacytInfrastructureBundle:Channel')->findAll();
        $auxChannel = [];

        foreach ($channels as $currentChannel) {
            $auxChannel['id'] = $currentChannel->getId();
            $auxChannel['name'] = $currentChannel->getName();
            $data['channels'][] = $auxChannel;
        }

        return $this->render('DSFacytInfrastructureBundle:User\Image:newImage.html.twig', array(
            'data' => json_encode($data)));
    }

     /**
     * La siguiente función publicar un imageo del usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param Request $request
     * @version 03/09/2015
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function validateNewAction(Request $request)
    {
        $image = new Image();

        /*if ($request->files->get('file')) {
            $currentImage = new File($request->files->get('file'));
            $document = new Document();
            $document->setFile($currentImage);
            $image->setDocument($document);
        }*/

        $form = $this->createForm(new RegisterImageType(), $image);


        $form->handleRequest($request);


        if ($form->isValid()) {

            $user = $security = $this->container->get('security.context')->getToken()->getUser();
            $image->setUser($user);
            $command = new UploadImageCommand($image, $user->getIndentityCard());
            $this->get('CommandBus')->execute($command);

            $validator = $this->get('validator');
            $errors = $validator->validate($image);

            if (count($errors) > 0) {
                return $this->render('DSFacytInfrastructureBundle:User\Image:newImage.html.twig', array('form' => $form->createView(), 'errors' => $errors));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute('ds_facyt_infrastructure_user_image_homepage');
        }

        return $this->render('DSFacytInfrastructureBundle:User\Image:newImage.html.twig', array('form' => $form->createView(),'data' => json_encode(['pathImage' => null])));
    }

    /**
     * La siguiente función se encarga de mostrar el formulario para editar los datos de una imagen
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param integer $textId
     * @version 30/09/2015
     * @return Response
     */
    public function editAction($imageId)
    {
        $command = new GetImageCommand($imageId);
        $response = $this->get('CommandBus')->execute($command);
        if ($response->getStatusCode() == 200) {           

            return $this->render('DSFacytInfrastructureBundle:User\Image:newImage.html.twig', array(
            'data' => json_encode($response->getData())));
        }

        return $this->redirect('ds_facyt_infrastructure_user_image_homepage');
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
    public function validateEditAction($imageId, Request $request)
    {
        if (!$imageId) {
            throw $this->createNotFoundException('Hubo un error a enviar el formulario');
        }

        $command = new EditImageCommand();
        $command->setImageId($imageId);
        $this->get('CommandBus')->execute($command);
        $form = $this->createForm(new RegisterImageType(), $command->getEntityImage(),
            array(
                'action' => $this->generateUrl('ds_facyt_infrastructure_user_image_edit_validate',array('imageId' => $imageId)),
                'method' => 'POST'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $image = $command->getEntityImage();
            $image->setStatus(0);

            $validator = $this->get('validator');
            $errors = $validator->validate($image);

            if (count($errors) > 0) {
                return $this->render('DSFacytInfrastructureBundle:User\Image:newImage.html.twig', array('form' => $form->createView(), 'errors' => $erros));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute('ds_facyt_infrastructure_user_image_homepage');
        }

        return $this->render('DSFacytInfrastructureBundle:User\Image:newImage.html.twig', array('form' => $form->createView()));
    }

    /**
    * La siguiente función se encarga de eliminar una imagen
    * dado un json que contiene el id de la imagen a eliminar
    *
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @param Request $request
    * @version 02/02/2015
    * @return Response
    */
    public function deleteAction( Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(),true);

            $command = new DeleteImageCommand();
            $command->setImageId($data['image_id']);

            $response = $this->get('CommandBus')->execute($command);

            if ($response->getStatusCode() == 201)
                return new Response('Ok', 201);    
            else
                return new Response('Bad Request', 401);
            
        }
        return new Response('Not Found',404);        
    }

    /**
    * La función se encarga de crear y editar
    * una publicación de tipo imagen vía ajax
    *
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @param Request $request
    **/
    public function setImageAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {

            $data = json_decode($request->request->get('data'), true);
            if ($request->files->get('file')) 
                $file = new File($request->files->get('file'));

            $user = $security = $this->container->get('security.context')->getToken()->getUser();
            $command = new SetImageCommand($file,$data, $user);
            $response = $this->get('CommandBus')->execute($command);

            return new JsonResponse($response->getMessage(), $response->getStatusCode());

        }

        return new JsonResponse('Bad Request', 400);
    }
}
