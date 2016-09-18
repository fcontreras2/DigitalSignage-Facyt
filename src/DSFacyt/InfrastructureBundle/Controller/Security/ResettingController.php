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
            return $this->render('DSFacytInfrastructureBundle:Resetting:passwordAlreadyRequested.html.twig');
        }

        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $this->sendConfirmationEmail($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->get('fos_user.user_manager')->updateUser($user);

        return new RedirectResponse($this->generateUrl('ds_facyt_infrastructure_resetting_check_email',
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
        $emailService->setSubject('Recuperar Contraseña - DSFacyt');

        $emailService->setViewRender('DSFacytInfrastructureBundle:Email:resettingPassword.html.twig');
        $emailData['confirmationUrl'] = $this->get('router')->generate('ds_facyt_infrastructure_resetting_reset', array('token' => $user->getConfirmationToken()), true);

        $emailService->setViewParameters($emailData);
        $emailService->setEmailSender('ds_facyt@uc.edu.ve');
        $emailService->sendEmail();
    }

    /**
     * Tell the user to check his email provider
     */
    public function checkEmailAction(Request $request)
    {
        $email = $request->query->get('email');
        if (empty($email)) {
            // the user does not come from the sendEmail action
            return new RedirectResponse($this->generateUrl('ds_facyt_infrastructure_resetting'));
        }

        return $this->render('DSFacytInfrastructureBundle:Resetting:checkEmail.html.twig', array(
            'email' => $email
        ));
    }


     /**
     * Reset user password
     */
    public function resetAction(Request $request, $token)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.resetting.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->findUserByConfirmationToken($token);
        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);
            $userManager->updateUser($user);
            if (null === $response = $event->getResponse()) {
                $response = new RedirectResponse($this->generateUrl('ds_facyt_infrastructure_resetting_update_password_success'));
            }
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
            return $response;
        }

        $requestAttributes = $this->container->get('request')->attributes;
        $route = $requestAttributes->get('_route');
     
        return $this->render('DSFacytInfrastructureBundle:Resetting:reset.html.twig', array(
            'token' => $token, 'form' => $form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function passwordUpdateSuccessAction()
    {
        return $this->render('DSFacytInfrastructureBundle:Resetting:updatePasswordSuccess.html.twig');     
    }     
}