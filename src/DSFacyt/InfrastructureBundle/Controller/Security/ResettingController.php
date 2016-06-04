<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace DSFacyt\InfrastructureBundle\Controller\Security;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Model\User;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller managing the resetting of the password
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ResettingController extends Controller
{
    /**
     * Request reset user password: show form
     */
    public function requestAction()
    {
        return $this->render('DSFacytInfrastructureBundle:Resetting:request.html.twig');
    }

    /**
     * Request reset user password: submit form and send email
     */
    public function sendEmailAction(Request $request)
    {
        $username = $request->request->get('username');
        /** @var $user UserInterface */
        $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        if (null === $user) {
            return $this->render('DSFacytInfrastructureBundle:Resetting:request.html.twig', array(
                'invalid_username' => $username
            ));
        }

        if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            return $this->render('DSFacytInfrastructureBundle:Resetting:request.html.twig', array(
                'invalid_username' => $username
            ));
        }

        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $this->sendConfirmationEmail($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->get('fos_user.user_manager')->updateUser($user);

        return new RedirectResponse($this->generateUrl('ds_facyt_resetting_register_check_email',
            array('email' => $user->getEmail())
        ));
    }

    /**
     * La función se encarga de enviar el correo de reinicio de contraseña
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param User $user
     * @param $route
     * @version 09/10/2015
     */
    public function sendConfirmationEmail($user)
    {
        $emailService = $this->get('EmailService');
        $emailService->setConfigEmail('first_mailer');
        $emailService->setRecipients(array($user->getEmail()));
        $emailService->setSubject('Recuperar Contraseña - Facyt');

        $emailService->setViewRender('NavicuInfrastructureBundle:Email:resettingPassword.html.twig');
        $emailData['confirmationUrl'] = $this->get('router')->generate('ds_facyt_resetting_register_reset', array('token' => $user->getConfirmationToken()), true);

        $emailService->setViewParameters($emailData);
        $emailService->setEmailSender('ds_facyt@uc.edu.ve');
        $emailService->sendEmail();
    }
}