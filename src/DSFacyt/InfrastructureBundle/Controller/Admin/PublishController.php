<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use DSFacyt\InfrastructureBundle\Entity\Text;
use DSFacyt\Core\Application\UseCases\Admin\Publish\GetPublishStatus\GetPublishStatusCommand;
use DSFacyt\Core\Application\UseCases\Text\EditText\EditTextCommand;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterTextType;

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
                $data['start_date'],
                $data['end_date'],
                $data['page']
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
        $form = $this->createForm(new RegisterTextType(), $text,
            array(
                'action' => $this->generateUrl('ds_facyt_infrastructure_admin_text_new_validate'),
                'method' => 'POST'));

        return $this->render('DSFacytInfrastructureBundle:Admin/Publish:newText.html.twig', array('form' => $form->createView()));
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
        $form = $this->createForm(new RegisterTextType(), $text);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $user = $security = $this->container->get('security.context')->getToken()->getUser();

            $text->setUser($user);
            $text->setStatus(0);

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
        $command = new EditTextCommand();
        $command->setTextId($textId);
        $response = $this->get('CommandBus')->execute($command);
        if ($response->getStatusCode() == 201) {
            $form = $this->createForm(new RegisterTextType(), $command->getEntityText(),
                array(
                    'action' => $this->generateUrl('ds_facyt_infrastructure_user_text_edit_validate',array('textId' => $textId)),
                    'method' => 'POST'));
            return $this->render('DSFacytInfrastructureBundle:Admin/Publish:newText.html.twig', array('form' => $form->createView()));
        }

        return $this->redirect('ds_facyt_infrastructure_user_text_homepage');
    }
}
