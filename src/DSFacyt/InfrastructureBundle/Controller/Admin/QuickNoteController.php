<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use DSFacyt\InfrastructureBundle\Entity\QuickNote;
use DSFacyt\InfrastructureBundle\Form\QuickNoteType;
use DSFacyt\Core\Application\UseCases\Admin\QuickNote\GetQuickNotes\GetQuickNotesCommand;


/**
 * Class QuickNoteController
 *
 *  Notas Rapidas del sistema
 *
 * @author Freddy Contreras <freddycontreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 * @version 05/01/2016
 * @package DSFacyt\InfrastructureBundle\Controller
 */
class QuickNoteController extends Controller
{
    /**
     * Lists all QuickNote entities.
     *
     */
    public function indexAction()
    {
        $command = new GetQuickNotesCommand();
        $response = $this->get('CommandBus')->execute($command);

        return $this->render('DSFacytInfrastructureBundle:Admin/QuickNote:index.html.twig', array(
            'data' => json_encode($response->getData())
        ));
    }
    /**
     * Creates a new QuickNote entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new QuickNote();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ds_facyt_infrastructure_admin_quicknote_show', array('id' => $entity->getId())));
        }

        return $this->render('DSFacytInfrastructureBundle:Admin/QuickNote:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a QuickNote entity.
     *
     * @param QuickNote $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(QuickNote $entity)
    {
        $form = $this->createForm(new QuickNoteType(), $entity, array(
            'action' => $this->generateUrl('ds_facyt_infrastructure_admin_quicknote_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new QuickNote entity.
     *
     */
    public function newAction()
    {
        $entity = new QuickNote();
        $form   = $this->createCreateForm($entity);

        return $this->render('DSFacytInfrastructureBundle:Admin/QuickNote:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a QuickNote entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DSFacytInfrastructureBundle:QuickNote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find QuickNote entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DSFacytInfrastructureBundle:Admin/QuickNote:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing QuickNote entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DSFacytInfrastructureBundle:QuickNote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find QuickNote entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DSFacytInfrastructureBundle:Admin/QuickNote:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a QuickNote entity.
    *
    * @param QuickNote $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(QuickNote $entity)
    {
        $form = $this->createForm(new QuickNoteType(), $entity, array(
            'action' => $this->generateUrl('ds_facyt_infrastructure_admin_quicknote_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing QuickNote entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DSFacytInfrastructureBundle:QuickNote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find QuickNote entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ds_facyt_infrastructure_admin_quicknote_edit', array('id' => $id)));
        }

        return $this->render('DSFacytInfrastructureBundle:Admin/QuickNote:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a QuickNote entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DSFacytInfrastructureBundle:QuickNote')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find QuickNote entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ds_facyt_infrastructure_admin_quicknote'));
    }

    /**
     * Creates a form to delete a QuickNote entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ds_facyt_infrastructure_admin_quicknote_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function apiGetQuickNotesAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(),true);
            $command = new GetQuickNotesCommand($data['page']);
            $response = $this->get('CommandBus')->execute($command);

            return new JsonResponse($response->getData(), $response->getStatusCode());
        }

        return new JsonResponse(null, 404);
    }
}
