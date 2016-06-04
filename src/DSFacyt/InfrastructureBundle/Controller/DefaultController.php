<?php

namespace DSFacyt\InfrastructureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use DSFacyt\InfrastructureBundle\Entity\Document;
use DSFacyt\InfrastructureBundle\Entity\User;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterType;
use DSFacyt\Core\Application\UseCases\Admin\Publish\GetPublishStatus\GetPublishStatusCommand;
use DSFacyt\Core\Application\UseCases\GetImportant\GetImportantCommand; 
use DSFacyt\Core\Application\UseCases\GetImportantAll\GetImportantAllCommand; 
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class DefaultController
 *
 * El siguiente controlador Se encarga de procesar y recibir las solicitudes referente
 * a las vista iniciales (homepage/registro/etc) del sistema
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31/08/2015
 * @package DSFacyt\InfrastructureBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * La siguiente función rendifica la vista del homepage del sistema
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @author Currently Working; Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31/08/2015
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {   
        $command = new GetImportantCommand();
        $response = $this->get('CommandBus')->execute($command);
        return $this->render('DSFacytInfrastructureBundle:Default:index.html.twig',['data' => $response->getData()]);
    }

    /**
     * La siguiente function crea la vista del registro del formulario
     *
     * @author Freddy Contreras <freddycontreras3@ŋmail.com>
     * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31/08/2015
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction()
    {   

        $user = new User();
        $form = $this->createForm(new RegisterType(), $user,
            array(
                'action' => $this->generateUrl('ds_facyt_infrastructure_validate_register'),
                'method' => 'POST'));
        
        return $this->render('DSFacytInfrastructureBundle:Security:register.html.twig',array('form' => $form->createView()));
    }

    /**
     * La siguiente función se encarga de validar el proceso de registro de un usuario
     *
     * @param Request $request
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @author Currently Working; Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31/08/2015
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerValidationAction(Request $request)
    {

        $user = new User();
        $form = $this->createForm(new RegisterType(), $user);
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setEnabled(true);
            $user->addRole(1);
            $user->setPlainPassword($user->getPassword());
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            $this->login($user->getUsername(),$user->getPassword());

            return $this->redirect($this->generateUrl('ds_facyt_infrastructure_user_homepage'));
            
        }

        return $this->render('DSFacytInfrastructureBundle:Security:register.html.twig',array('form' => $form->createView()));
    }

    /**
     * La siguiente función verifica que un usuario se encuentre registrado y 
     * inicia la sesión del usario automatica
     * 
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param string $username
     * @param string $password
     * @return boolean
     */
    private function login($username, $password)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');

        //Se busca al usuario por su username
        $user = $user_manager->loadUserByUsername($username);

        $encoder = $factory->getEncoder($user);

        //Se verifica si password corresponde
        //Si el password corresponde se inicia la sesión
        if ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) {
            $token = new UsernamePasswordToken($user, null, "user", $user->getRoles());
            $this->get("security.context")->setToken($token); 
            return true;
        }        
        return false;
    }

    /**
     * Retorna las publicaciones vía Ajax de un usuario
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
            $status = isset($data['status']) ? $data['status'] : null;
            $user =  $this->container->get('security.context')->getToken()->getUser();

            $command = new GetPublishStatusCommand(
                $data['type'],
                $status,
                $startDate,
                $endDate,
                $data['page'],
                $user
            );

            if (isset($data['filter']))
                $command->setFilter($data['filter']);

            if (isset($data['order']))
                $command->setOrder($data['order']);

            $response = $this->get('CommandBus')->execute($command);
            return new JsonResponse($response->getData(), 200);
        }

        return new JsonResponse('Error', 503);
    }

    public function getImportantAction()
    {
        $command = new GetImportantAllCommand();
        $response = $this->get('CommandBus')->execute($command);

        return $this->render("DSFacytInfrastructureBundle:Default:importants.html.twig", ['data' => $response->getData()]);
    }
}
