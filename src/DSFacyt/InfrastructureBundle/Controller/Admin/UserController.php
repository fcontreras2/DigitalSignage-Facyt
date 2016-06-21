<?php

namespace DSFacyt\InfrastructureBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use DSFacyt\InfrastructureBundle\Entity\User;
use DSFacyt\InfrastructureBundle\Entity\Group;
use DSFacyt\InfrastructureBundle\Form\UserType;
use DSFacyt\Core\Application\UseCases\Admin\Users\SetUser\SetUserCommand;
use DSFacyt\Core\Application\UseCases\Admin\Users\GetUser\GetUserCommand;
use DSFacyt\Core\Application\UseCases\Admin\Users\GetUsers\GetUsersCommand;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $command = new GetUsersCommand(1);
        $response = $this->get('CommandBus')->execute($command);
        return $this->render('DSFacytInfrastructureBundle:Admin/User:index.html.twig', ['data' => json_encode($response->getData())]);
    }
    /**
     * Creates a new User entity.
     *
     */
    public function createAction()
    {

        $data = ['groups' => []];
        $manager = $this->container->get('doctrine.orm.entity_manager');

        $groups = $manager->getRepository('DSFacytInfrastructureBundle:Group')->findAll();
        $auxGroup = [];

        foreach ($groups as $currentGroup) {
            $auxGroup['id'] = $currentGroup->getId();
            $auxGroup['name'] = $currentGroup->getName();
            $data['groups'][] = $auxGroup;
        }

        return $this->render('DSFacytInfrastructureBundle:Admin/User:new.html.twig', ['data' => json_encode($data)]);
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('ds_facyt_admin_user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $data = ['groups' => [], 'school' => []];
        $manager = $this->container->get('doctrine.orm.entity_manager');

        $groups = $manager->getRepository('DSFacytInfrastructureBundle:Group')->findAll();
        $auxGroup = [];

        foreach ($groups as $currentGroup) {
            $auxGroup['id'] = $currentGroup->getId();
            $auxGroup['name'] = $currentGroup->getName();
            $data['groups'][] = $auxGroup;
        }

        $schools = $manager->getRepository('DSFacytInfrastructureBundle:School')->findAll();
        $auxSchool = [];

        foreach ($schools as $currentSchool) {
            $auxSchool['id'] = $currentSchool->getId();
            $auxSchool['name'] = $currentSchool->getName();
            $data['schools'][] = $auxSchool;
        }

        return $this->render('DSFacytInfrastructureBundle:Admin/User:new.html.twig', ['data' => json_encode($data)]);
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DSFacytInfrastructureBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DSFacytInfrastructureBundle:Admin/User:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $command = new GetUserCommand($id);
        $response = $this->get('CommandBus')->execute($command)->getData();

        $response['groups'] = [];
        $response['schools'] = [];
        $manager = $this->container->get('doctrine.orm.entity_manager');

        $groups = $manager->getRepository('DSFacytInfrastructureBundle:Group')->findAll();
        $auxGroup = [];

        foreach ($groups as $currentGroup) {
            $auxGroup['id'] = $currentGroup->getId();
            $auxGroup['name'] = $currentGroup->getName();
            $response['groups'][] = $auxGroup;
        }

        $schools = $manager->getRepository('DSFacytInfrastructureBundle:School')->findAll();
        $auxSchool = [];

        foreach ($schools as $currentSchool) {
            $auxSchool['id'] = $currentSchool->getId();
            $auxSchool['name'] = $currentSchool->getName();
            $response['schools'][] = $auxSchool;
        }

        return $this->render('DSFacytInfrastructureBundle:Admin/User:new.html.twig', ['data' => json_encode($response)]);
    }        

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('ds_facyt_admin_user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DSFacytInfrastructureBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ds_facyt_admin_user_edit', array('id' => $id)));
        }

        return $this->render('DSFacytInfrastructureBundle:Admin/User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DSFacytInfrastructureBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ds_facyt_admin_user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ds_facyt_admin_user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function setUserAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(),true);            
            $command = new SetUserCommand($data);
            $response = $this->get('CommandBus')->execute($command);
            return new JsonResponse(null, $response->getStatusCode());
        }

        return new JsonResponse('Bad Request', 400);
    }

    public function apiAjaxGetUsersAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(), true);
            
            $command = new GetUsersCommand($data['page']);
            $response = $this->get('CommandBus')->execute($command);
            return new JsonResponse($response->getData(), $response->getStatusCode());
        }

        return new JsonResponse('Bad Request', 400);
    }
}
