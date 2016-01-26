<?php
namespace DSFacyt\InfrastructureBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\EventListener\AuthenticationListener as FOSAuthenticationListener;

/**
* La clase de encarga de el procesod e autentificación de un usuario al registrarse
* 
* @author Freddy Coontreras <freddycontreras3@gmail.com>
*/
class AuthenticationListener extends FOSAuthenticationListener
{

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => 'authenticate',
            FOSUserEvents::REGISTRATION_CONFIRMED => 'authenticate'
        );
    }
}