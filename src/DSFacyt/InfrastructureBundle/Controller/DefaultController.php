<?php

namespace DSFacyt\InfrastructureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DSFacyt\Core\Domain\Model\Entity\Document;

class DefaultController extends Controller
{
    public function indexAction()
    {   
        return $this->render('DSFacytInfrastructureBundle:Default:index.html.twig');
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
