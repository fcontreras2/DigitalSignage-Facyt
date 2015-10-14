<?php

namespace DSFacyt\InfrastructureBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DSFacyt\InfrastructureBundle\Form\Type\RegisterImageType;
use DSFacyt\Core\Domain\Model\Entity\Image;
use DSFacyt\Core\Domain\Model\Entity\Document;

use DSFacyt\Core\Application\UseCases\Image\GetImages\GetImagesCommand;


/**
 * Class ImageController
 *
 * El siguiente Controlador se encarga de recibir y procesar las solicitudes referentes a las publicaciones
 * de tipo Imagenes de los usuarios
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 31/08/2015
 * @package DSFacyt\InfrastructureBundle\Controller\User
 */
class ImageController extends Controller
{
    /**
     * La siguiente funcion se encarga de rendeficar a la vista de las Imagenes del usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
     * @version 31/08/2015
     * @return Response
     */
    public function indexAction()
    {
        $command = new GetImagesCommand();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $command->setUser($user);

        $response = $this->get('CommandBus')->execute($command);

        return $this->render('DSFacytInfrastructureBundle:User\Image:index.html.twig', array('data' => json_encode($response->getData())));
    }

    /**
     * La siguiente Función se encarga de mostrar el formulario de
     * las pubicaciones nuevas de tipo imageo
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @version 02/09/2015
     * @return Response
     */
    public function publishNewAction()
    {
        $image = new Image();
        $form = $this->createForm(new RegisterImageType(), $image,
            array(
                'action' => $this->generateUrl('ds_facyt_infrastructure_user_image_new_validate'),
                'method' => 'POST'));

        return $this->render('DSFacytInfrastructureBundle:User\Image:newImage.html.twig', array('form' => $form->createView()));
    }

     /**
     * La siguiente función publicar un imageo del usuario
     *
     * @author Freddy Contreras <freddycontreras3@gmail.com>
     * @param Request $request
     * @version 03/09/2015
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function validateNewAction(Request $request)
    {
        $image = new Image();
        
        /*if ($request->files->get('file')) {
            $currentImage = new File($request->files->get('file'));
            $document = new Document();
            $document->setFile($currentImage);
            $image->setDocument($document);
        }*/
        
        $form = $this->createForm(new RegisterImageType(), $image);


        $form->handleRequest($request);


        if ($form->isValid()) {

            $user = $security = $this->container->get('security.context')->getToken()->getUser();

            $image->setUser($user);
            $image->setStatus('Pendiente');

            $validator = $this->get('validator');
            $errors = $validator->validate($image);

            if (count($errors) > 0) {
                return $this->render('DSFacytInfrastructureBundle:User\Image:newImage.html.twig', array('form' => $form->createView(), 'errors' => $erros));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute('ds_facyt_infrastructure_user_image_homepage');
        }

        return $this->render('DSFacytInfrastructureBundle:User\Image:newImage.html.twig', array('form' => $form->createView()));

    }
}
