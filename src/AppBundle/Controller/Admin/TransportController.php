<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Transport;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\TransportType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Controller used to manage transports in the backend.
 *
 * @Route("/admin/transport")
 * @Security("has_role('ROLE_ADMIN')")
 */
class TransportController extends Controller
{
    /**
     * Lists all Transport entities.
     *
     * @Route("/", name="admin_transport_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $transports = $entityManager->getRepository(Transport::class)->findAll();

        return $this->render('admin/transport/index.html.twig', ['transports' => $transports]);
    }

    /**
     * Creates a new Transport entity.
     *
     * @Route("/new", name="admin_transport_new")
     * @Method({"GET", "POST"})
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newAction(Request $request)
    {
        $transport = new Transport();
        
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(TransportType::class, $transport)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See http://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transport);
            $entityManager->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See http://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', 'transport.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_transport_new');
            }

            return $this->redirectToRoute('admin_transport_index');
        }

        return $this->render('admin/transport/new.html.twig', [
            'transport' => $transport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{id}", requirements={"id": "\d+"}, name="admin_transport_show")
     * @Method("GET")
     */
    public function showAction(Transport $transport)
    {

        $deleteForm = $this->createDeleteForm($transport);

        return $this->render('admin/transport/show.html.twig', [
            'transport'        => $transport,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Transport entity.
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_transport_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Transport $transport, Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(TransportType::class, $transport);
        $deleteForm = $this->createDeleteForm($transport);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'transport.updated_successfully');

            return $this->redirectToRoute('admin_transport_edit', ['id' => $transport->getId()]);
        }

        return $this->render('admin/transport/edit.html.twig', [
            'transport'        => $transport,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a Transport entity by id.
     *
     * @param Transport $transport The transport object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Transport $transport)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_transport_delete', ['id' => $transport->getId()]))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Deletes a Transport entity.
     *
     * @Route("/{id}", name="admin_transport_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Transport $transport)
    {
        $form = $this->createDeleteForm($transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($transport);
            $entityManager->flush();

            $this->addFlash('success', 'transport.deleted_successfully');
        }

        return $this->redirectToRoute('admin_transport_index');
    }
}
