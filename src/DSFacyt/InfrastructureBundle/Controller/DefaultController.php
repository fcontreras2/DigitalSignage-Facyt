<?php

namespace DSFacyt\InfrastructureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DSFacyt\Core\Domain\Model\Entity\Document;
use DSFacyt\Core\Domain\Model\Entity\User;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterType;


class DefaultController extends Controller
{
    public function indexAction()
    {   
        return $this->render('DSFacytInfrastructureBundle:Default:index.html.twig');
    }

    public function registerAction()
    {   

        $user = new User();
        $form = $this->createForm(new RegisterType(), $user,
            array(
                'action' => $this->generateUrl('ds_facyt_infrastructure_validate_register'),
                'method' => 'POST'));
        
        return $this->render('DSFacytInfrastructureBundle:Security:register.html.twig',array('form' => $form->createView()));
    }

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

    public function testImageAction()
    {
        $document = new Document();

        $form = $this->createFormBuilder($document)
        ->setAction($this->generateUrl('ds_facyt_infrastructure_show_image'))
        ->setMethod('POST')
        ->add('name')
        ->add('file','file')
        ->getForm();

        return $this->render('DSFacytInfrastructureBundle:Default:uploadimage.html.twig', array(
            'form' => $form->createView()));
    }

    public function showImageAction(Request $request)
    {
        $document = new Document();
        $form = $this->createFormBuilder($document)
        ->setMethod('POST')
        ->add('name')
        ->add('file','file')
        ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $document->upload($document->getFile()->getClientOriginalName(), '/images/images_original/');

            $em->persist($document);
            $em->flush();
        }

        return $this->render('DSFacytInfrastructureBundle:Default:showimage.html.twig', array('path' => $document->getWebPath()));
    }
}
