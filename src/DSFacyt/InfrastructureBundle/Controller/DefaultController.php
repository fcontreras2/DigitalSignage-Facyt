<?php

namespace DSFacyt\InfrastructureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use DSFacyt\Core\Domain\Model\Entity\Document;
use DSFacyt\Core\Domain\Model\Entity\User;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterType;

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

            return $this->redirectToRoute('ds_facyt_infrastructure_homepage');
        }

        return $this->render('DSFacytInfrastructureBundle:Security:register.html.twig',array('form' => $form->createView()));
    }
}
