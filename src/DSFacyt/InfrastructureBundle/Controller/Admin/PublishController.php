<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use DSFacyt\InfrastructureBundle\Entity\Text;
use DSFacyt\Core\Application\UseCases\Admin\Publish\GetPublishStatus\GetPublishStatusCommand;
use DSFacyt\Core\Application\UseCases\Text\EditText\EditTextCommand;
use DSFacyt\Core\Application\UseCases\Image\DeleteImage\DeleteImageCommand;
use DSFacyt\Core\Application\UseCases\Text\DeleteText\DeleteTextCommand;
use DSFacyt\Core\Application\UseCases\Admin\Publish\UpdateImportant\UpdateImportantCommand;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterAdminTextType;
use DSFacyt\Core\Application\UseCases\Text\SetText\SetTextCommand;
use DSFacyt\Core\Application\UseCases\Text\GetText\GetTextCommand;
use Symfony\Component\HttpFoundation\File\File;

use DSFacyt\Core\Application\UseCases\Image\SetImage\SetImageCommand;
use DSFacyt\Core\Application\UseCases\Image\GetImage\GetImageCommand;


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

    /**
    * @var array posibles estados de una publicación
    **/
    private $status = ['Nuevo','Aceptada','Cancelada','Finalizada'];

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
            default:
                $typeEntity = null;
        }

        $response = ['type' => $typeEntity, 'status' =>  $status];
        $user =  $this->container->get('security.context')->getToken()->getUser();
        $command = new GetPublishStatusCommand($typeEntity,$status, null,null,null, $user);
        $response['data'] = $this->get('CommandBus')->execute($command)->getData();
        return $this->render($template,['data' => json_encode($response)]);
    }

    /**
    * La siguiente función cambiar la importanción de una publicación
    * 
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @param Request $request
    **/
    public function updateImportantAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(),true);
            $command = new UpdateImportantCommand(
                $data['type'],
                $data['important'],
                $data['publish_id']
            );

            $response = $this->get('CommandBus')->execute($command);

            return new JsonResponse($response->getMessage(), $response->getStatusCode());
        }

        return new JsonResponse('Bad Request', 400);
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
            $startDate = isset($data['start_date']) ? $data['start_date'] : null;
            $endDate = isset($data['end_date']) ? $data['end_date'] : null;
            $user =  $this->container->get('security.context')->getToken()->getUser();
            
            $command = new GetPublishStatusCommand(
                $data['type'],
                $data['status'],
                $data['start_date'],
                $data['end_date'],
                $data['page'],
                $user
            );

            $response = $this->get('CommandBus')->execute($command);
            return new JsonResponse($response->getData(), 200);
        }

        return new JsonResponse('Error', 503);
    }

    /**
     * La siguiente Función se encarga de mostrar el formulario de
     * las pubicaciones nuevas de tipo texto
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 02/09/2015
     * @return Response
     */
    public function newTextAction()
    {
        $text= new Text();
        $data = ['channels' => []];
        $manager = $this->container->get('doctrine.orm.entity_manager');

        $channels = $manager->getRepository('DSFacytInfrastructureBundle:Channel')->findAll();
        $auxChannel = [];

        foreach ($channels as $currentChannel) {
            $auxChannel['id'] = $currentChannel->getId();
            $auxChannel['name'] = $currentChannel->getName();
            $data['channels'][] = $auxChannel;
        }

        $data['status'] = $this->status;

        return $this->render('DSFacytInfrastructureBundle:Admin\Publish:newText.html.twig', array(
            'data' => json_encode($data)));        
    }

    /**
     * La siguiente función publicar un texto del usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param Request $request
     * @version 03/09/2015
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function validateTextAction(Request $request)
    {
        $text = new Text();
        $form = $this->createForm(new RegisterAdminTextType(), $text);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $user = $security = $this->container->get('security.context')->getToken()->getUser();

            $text->setUser($user);
            
            $validator = $this->get('validator');
            $errors = $validator->validate($text);

            if (count($errors) > 0) {
                return $this->render('DSFacytInfrastructureBundle:Admin/Publish:newText.html.twig', array('form' => $form->createView(), 'errors' => $erros));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($text);
            $em->flush();

            return $this->redirectToRoute('ds_facyt_infrastructure_get_publish_type_status',['type' => 'text']);
        }

        return $this->render('DSFacytInfrastructureBundle:Admin/Publish:newText.html.twig', array('form' => $form->createView()));

    }

    /**
     * La siguiente función se encarga de mostrar el formulario para editar los datos de un texto
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param integer $textId
     * @version 30/09/2015
     * @return Response
     */
    public function editTextAction($textId)
    {
        $command = new GetTextCommand($textId);
        $response = $this->get('CommandBus')->execute($command);
        if ($response->getStatusCode() == 200) {           

            return $this->render('DSFacytInfrastructureBundle:Admin\Publish:newText.html.twig', array(
            'data' => json_encode($response->getData())));
        }

        return $this->redirect('ds_facyt_infrastructure_admin_homepage');
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
    public function validateEditAction($textId, Request $request)
    {
        if (!$textId) {
            throw $this->createNotFoundException('Hubo un error a enviar el formulario');
        }

        $command = new EditTextCommand();
        $command->setTextId($textId);
        $this->get('CommandBus')->execute($command);
        $form = $this->createForm(new RegisterAdminTextType(), $command->getEntityText(),
            array(
                'action' => $this->generateUrl('ds_facyt_infrastructure_admin_text_edit_validate',array('textId' => $textId)),
                'method' => 'POST'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $text = $command->getEntityText();
            $text->setStatus(0);

            $validator = $this->get('validator');
            $errors = $validator->validate($text);

            if (count($errors) > 0) {
                return $this->render('DSFacytInfrastructureBundle:Admin\Publish:newText.html.twig', array('form' => $form->createView(), 'errors' => $erros));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($text);
            $em->flush();

            return $this->redirectToRoute('ds_facyt_infrastructure_get_publish_type_status',['type' => 'text']);
        }

        return $this->render('DSFacytInfrastructureBundle:Admin\Text:newText.html.twig', array('form' => $form->createView()));
    }

    /**
    * Función elimina una publicación vía ajax
    * Dada un id de la publicación y un tipo de publicación a eliminar
    * 
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @param Request $request
    * @return JsonResponse
    */
    public function deletePublishAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(),true);

            switch ($data['type']) {
                case 'Text':
                    $command = new DeleteTextCommand();
                    $command->setTextId($data['publish_id']);
                    break;
                case 'Image':
                    $command = new DeleteImageCommand();
                    $command->setImageId($data['publish_id']);                
                    break;
                default:
                    $command = null;
                    break;
            }

            if ($command) {
                $response = $this->get('CommandBus')->execute($command);
                if ($response->getStatusCode() == 201)
                    return new JsonResponse('Ok', 201);
                else 
                    return new JsonResponse($response->getMessage(), $response->getStatusCode());
            }            
            return new JsonResponse('Bad Request',400);        
        }

        return new JsonResponse('Not Found',404);        
    }

    /**
    * La función se encarga de crear y editar
    * una publicación de tipo Texto vía ajax
    *
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @param Request $request
    **/
    public function setTextAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {

            $data = json_decode($request->getContent(),true);
            $user = $security = $this->container->get('security.context')->getToken()->getUser();
            $command = new SetTextCommand($data, $user);
            $response = $this->get('CommandBus')->execute($command);

            return new JsonResponse($response->getMessage(), $response->getStatusCode());

        }

        return new JsonResponse('Bad Request', 400);
    }


    /**
     * La siguiente Función se encarga de mostrar el formulario de
     * las pubicaciones nuevas de tipo texto
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 02/09/2015
     * @return Response
     */
    public function newImageAction()
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

        $data['status'] = $this->status;

        return $this->render('DSFacytInfrastructureBundle:Admin\Publish:newImage.html.twig', array(
            'data' => json_encode($data)));        
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

    /**
     * La siguiente función se encarga de mostrar el formulario para editar los datos de un imagen
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param integer $imageId
     * @version 30/09/2015
     * @return Response
     */
    public function editImageAction($imageId)
    {
        $command = new GetImageCommand($imageId);
        $response = $this->get('CommandBus')->execute($command);
        if ($response->getStatusCode() == 200) {           

            return $this->render('DSFacytInfrastructureBundle:Admin\Publish:newImage.html.twig', array(
            'data' => json_encode($response->getData())));
        }

        return $this->redirect('ds_facyt_infrastructure_admin_homepage');
    }
}
