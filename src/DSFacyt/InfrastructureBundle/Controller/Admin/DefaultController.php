<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 *
 * El siguiente controlador Se encarga de procesar y recibir las solicitudes referente
 * a las vista iniciales del administrador
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 05/01/2016
 * @package DSFacyt\InfrastructureBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * La siguiente función rendifica la vista del homepage del panel de administrador
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @author Currently Working; Freddy Contreras <freddycontreras3@gmail.com>
     * @version 05/01/2016
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('DSFacytInfrastructureBundle:Admin:index.html.twig');
        //return $this->render('DSFacytInfrastructureBundle:Default:index.html.twig');
    }
}
