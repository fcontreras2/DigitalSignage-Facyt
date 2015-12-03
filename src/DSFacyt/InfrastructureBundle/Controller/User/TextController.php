<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DSFacyt\Core\Domain\Model\Entity\Text;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterTextType;

use DSFacyt\Core\Application\UseCases\Text\GetTexts\GetTextsCommand;
use DSFacyt\Core\Application\UseCases\Text\EditText\EditTextCommand;
use DSFacyt\Core\Application\UseCases\Text\DeleteText\DeleteTextCommand;
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
    public function indexAction($page)
    {
        $command = new GetTextsCommand();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $command->setUser($user);
        $command->setPage($page);

        $response = $this->get('CommandBus')->execute($command);

        return $this->render('DSFacytInfrastructureBundle:User\Text:index.html.twig', array('data' => json_encode($response->getData())));
    }

    /**
     * La siguiente Función se encarga de mostrar el formulario de
     * las pubicaciones nuevas de tipo texto
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 02/09/2015
     * @return Response
     */
    public function publishNewAction()
    {
        $text= new Text();
        $form = $this->createForm(new RegisterTextType(), $text,
            array(
                'action' => $this->generateUrl('ds_facyt_infrastructure_user_text_new_validate'),
                'method' => 'POST'));

        return $this->render('DSFacytInfrastructureBundle:User\Text:newText.html.twig', array('form' => $form->createView()));
    }

    /**
     * La siguiente función publicar un texto del usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param Request $request
     * @version 03/09/2015
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function validateNewAction(Request $request)
    {
        $text = new Text();
        $form = $this->createForm(new RegisterTextType(), $text);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $user = $security = $this->container->get('security.context')->getToken()->getUser();

            $text->setUser($user);
            $text->setStatus('Pendiente');

            $validator = $this->get('validator');
            $errors = $validator->validate($text);

            if (count($errors) > 0) {
                return $this->render('DSFacytInfrastructureBundle:User\Text:newText.html.twig', array('form' => $form->createView(), 'errors' => $erros));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($text);
            $em->flush();

            return $this->redirectToRoute('ds_facyt_infrastructure_user_text_homepage');
        }

        return $this->render('DSFacytInfrastructureBundle:User\Text:newText.html.twig', array('form' => $form->createView()));

    }

    /**
     * La siguiente función se encarga de mostrar el formulario para editar los datos de un texto
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param integer $textId
     * @version 30/09/2015
     * @return Response
     */
    public function editAction($textId)
    {
        $command = new EditTextCommand();
        $command->setTextId($textId);
        $response = $this->get('CommandBus')->execute($command);
        if ($response->getStatusCode() == 201) {
            $form = $this->createForm(new RegisterTextType(), $command->getEntityText(),
                array(
                    'action' => $this->generateUrl('ds_facyt_infrastructure_user_text_edit_validate',array('textId' => $textId)),
                    'method' => 'POST'));
            return $this->render('DSFacytInfrastructureBundle:User\Text:newText.html.twig', array('form' => $form->createView()));
        }

        return $this->redirect('ds_facyt_infrastructure_user_text_homepage');
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
        $form = $this->createForm(new RegisterTextType(), $command->getEntityText(),
            array(
                'action' => $this->generateUrl('ds_facyt_infrastructure_user_text_edit_validate',array('textId' => $textId)),
                'method' => 'POST'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $text = $command->getEntityText();
            $text->setStatus('Pendiente');

            $validator = $this->get('validator');
            $errors = $validator->validate($text);

            if (count($errors) > 0) {
                return $this->render('DSFacytInfrastructureBundle:User\Text:newText.html.twig', array('form' => $form->createView(), 'errors' => $erros));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($text);
            $em->flush();

            return $this->redirectToRoute('ds_facyt_infrastructure_user_text_homepage');
        }

        return $this->render('DSFacytInfrastructureBundle:User\Text:newText.html.twig', array('form' => $form->createView()));
    }

    /**
    * La siguiente función se encarga de eliminar un texto
    * dado un json que contiene el id del texto a eliminar
    *
    * @author Freddy Contreras <freddycontreras3@gmail.com>
    * @param Request $request
    * @version 06/10/2015
    * @return Response
    */
    public function deleteAction( Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(),true);

            $command = new DeleteTextCommand();
            $command->setTextId($data['text_id']);

            $response = $this->get('CommandBus')->execute($command);

            if ($response->getStatusCode() == 201)
                return new Response('Ok', 201);    
            else
                return new Response('Bad Request', 401);
            
        }
        return new Response('Not Found',404);        
    }
}
