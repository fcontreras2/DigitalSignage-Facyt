<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class DefaultController
 *
 * El siguiente controlador se declaran todas las funciones o funcionalidades
 * que no tienen un lógica de negocio en la sesión del usuario
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31/08/2015
 * @package DSFacyt\InfrastructureBundle\Controller\User
 */
class DefaultController extends Controller
{
    /**
     * La siguiente funcion se encarga de rendificar la vista del home del usuario (panel)
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31/08/2015
     * @return Response
     */
    public function indexPanelAction()
    {   
        return $this->render('DSFacytInfrastructureBundle:User:index.html.twig');
    }
}
