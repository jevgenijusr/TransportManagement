<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Timesheet;

use AppBundle\Form\ChooseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\TimesheetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Controller used to manage timesheets in the backend.
 *
 * @Route("/admin/timesheet")
 */
class TimesheetController extends Controller
{
    /**
     * Lists all Timesheet entities.
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/", name="admin_timesheet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $timesheets = $entityManager->getRepository(Timesheet::class)->findAll();

        return $this->render('admin/timesheet/index.html.twig', ['timesheets' => $timesheets]);
    }

    /**
     * Creates a new Timesheet entity.
     *
     * @Route("/new", name="admin_timesheet_new")
     * @Method({"GET", "POST"})
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newAction(Request $request)
    {
        $timesheet = new Timesheet();
        
        // See http://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(TimesheetType::class, $timesheet)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See http://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($timesheet);
            $entityManager->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See http://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', 'timesheet.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_timesheet_new');
            }

            return $this->redirectToRoute('admin_timesheet_index');
        }

        return $this->render('admin/timesheet/new.html.twig', [
            'timesheet' => $timesheet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Timesheet entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_timesheet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Timesheet $timesheet, Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(TimesheetType::class, $timesheet);
        $deleteForm = $this->createDeleteForm($timesheet);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'timesheet.updated_successfully');

            return $this->redirectToRoute('admin_timesheet_edit', ['id' => $timesheet->getId()]);
        }

        return $this->render('admin/timesheet/edit.html.twig', [
            'timesheet'        => $timesheet,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a Timesheet entity by id.
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Timesheet $timesheet The timesheet object
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Timesheet $timesheet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_timesheet_delete', ['id' => $timesheet->getId()]))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Deletes a Timesheet entity.
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}", name="admin_timesheet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Timesheet $timesheet)
    {
        $form = $this->createDeleteForm($timesheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($timesheet);
            $entityManager->flush();

            $this->addFlash('success', 'timesheet.deleted_successfully');
        }

        return $this->redirectToRoute('admin_timesheet_index');
    }

    /**
     * Allows to choose User and Month
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/start", name="admin_timesheet_start")
     */
    public function startAction(Request $request)
    {
        $form = $this->createForm(ChooseType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            return $this->redirectToRoute('admin_timesheet_index_filtered', [
                'user_id' => $form->getData()['user']->getId(),
                'month' => $form->getData()['date']
            ]);
        }

        return $this->render('admin/timesheet/choose.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Filter timesheets based on user id and month
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/index/filtered", name="admin_timesheet_index_filtered")
     * @Method("GET")
     */
    public function filteredIndexAction(Request $request)
    {
        $timesheets = $this->getDoctrine()->getRepository(Timesheet::class)->findForYearAndMonth(
            $request->query->get('month'),
            $request->query->get('user_id')
        );

        return $this->render('admin/timesheet/index_filtered.html.twig', ['timesheets' => $timesheets]);
    }

}
