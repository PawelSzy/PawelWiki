<?php

namespace PawelWikiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PawelWikiBundle\Entity\AutorDB;
use PawelWikiBundle\Form\AutorDBType;

/**
 * AutorDB controller.
 *
 */
class AutorDBController extends Controller
{

    /**
     * Lists all AutorDB entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PawelWikiBundle:AutorDB')->findAll();

        return $this->render('PawelWikiBundle:AutorDB:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new AutorDB entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new AutorDB();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('autordb_show', array('id' => $entity->getId())));
        }

        return $this->render('PawelWikiBundle:AutorDB:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a AutorDB entity.
     *
     * @param AutorDB $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AutorDB $entity)
    {
        $form = $this->createForm(new AutorDBType(), $entity, array(
            'action' => $this->generateUrl('autordb_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utworz'));

        return $form;
    }

    /**
     * Displays a form to create a new AutorDB entity.
     *
     */
    public function newAction()
    {
        $entity = new AutorDB();
        $form   = $this->createCreateForm($entity);

        return $this->render('PawelWikiBundle:AutorDB:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AutorDB entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PawelWikiBundle:AutorDB')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AutorDB entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PawelWikiBundle:AutorDB:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AutorDB entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PawelWikiBundle:AutorDB')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AutorDB entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PawelWikiBundle:AutorDB:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a AutorDB entity.
    *
    * @param AutorDB $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AutorDB $entity)
    {
        $form = $this->createForm(new AutorDBType(), $entity, array(
            'action' => $this->generateUrl('autordb_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AutorDB entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PawelWikiBundle:AutorDB')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AutorDB entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('autordb_edit', array('id' => $id)));
        }

        return $this->render('PawelWikiBundle:AutorDB:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AutorDB entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PawelWikiBundle:AutorDB')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AutorDB entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('autordb'));
    }

    /**
     * Creates a form to delete a AutorDB entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('autordb_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
