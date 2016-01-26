<?php

namespace DSFacyt\InfrastructureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use DSFacyt\Core\Domain\Model\Entity\Document;
use DSFacyt\Core\Domain\Model\Entity\User;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterType;
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
        return $this->render('DSFacytInfrastructureBundle:Default:index.html.twig');
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
}
