<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PersonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Controller managing the person profile`
 *
 * @Route("/admin/person")
 */
class AdminPersonController extends Controller
{
    /**
     * Show lists of Persons
     *
     * @Method("GET")
     * @Route("/index.html", name="admin_persons")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     * 
     * @return Template
     */
    public function indexAction()
    {
        $csrf = $this->container->get('form.csrf_provider');

        $fields = array(
            'id',
            'person.admin.person.name.given.text',
            'person.admin.person.name.family.text',
            'person.admin.person.email.text',
            'person.admin.postalAddress.address.country.text'
        );

        return array(
            'keys'  => $fields,
            'csrf'  => $csrf
        );
    }

    /**
     * Show lists of Persons
     *
     * @Method("GET")
     * @Route("/list.json", name="admin_persons_json")
     * @Secure(roles="ROLE_ADMIN")
     * 
     * @return Response
     */
    public function ajaxListAction()
    {
        $documentManager    = $this->getManager();
        $repository         = $documentManager->getRepository();

        $rawDocuments       = $repository->findAll();

        $documents = array('aaData' => array());
        foreach ($rawDocuments as $document) {
            if ($document->getAddress()->first()) {
                $country = $document->getAddress()->first()->getAddressCountryLocale($this->getRequest()->getLocale());
            } else {
                $country = null;
            }
            $documents['aaData'][] = array(
                $document->getId(),
                $document->getGivenName(),
                $document->getFamilyName(),
                $document->getEmail(),
                $country,
                null
            );
        }

        return new Response(json_encode($documents));
    }

    /**
     * Show a person
     *
     * @param integer $id
     * 
     * @Method({"GET"})
     * @Route("/{id}/show", name="admin_person_show")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     * 
     * @return Template
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($id)
    {
        $documentManager = $this->getManager();
        $repository = $documentManager->getRepository();

        $document   = $repository->findOneById($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Person document.');
        }

        $form = $this->createForm($this->get('black_person.contact.form.type'), array('id' => $id));
        $locale = $this->getRequest()->getLocale();

        return array(
            'document'      => $document,
            'locale'        => $locale,
            'form'          => $form->createView()
        );
    }

    /**
     * Displays a form to create a new Person document.
     *
     * @Method({"GET", "POST"})
     * @Route("/new", name="admin_person_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     * @return Template
     */
    public function newAction()
    {
        $documentManager    = $this->getManager();
        $document           = $documentManager->createInstance();

        $formHandler    = $this->get('black_person.person.form.handler');
        $process        = $formHandler->process($document);

        if ($process) {
            $documentManager->persist($document);
            $documentManager->flush();

            return $this->redirect($this->generateUrl('admin_person_edit', array('id' => $document->getId())));
        }

        return array(
            'document'  => $document,
            'form'      => $formHandler->getForm()->createView()
        );
    }

    /**
     * Displays a form to edit an existing Person document.
     *
     * @param string $id The document ID
     * 
     * @Method({"GET", "POST"})
     * @Route("/{id}/edit", name="admin_person_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function editAction($id)
    {
        $manager    = $this->getManager();
        $repository = $manager->getRepository();

        $person     = $repository->findOneById($id);

        if (!$person) {
            throw $this->createNotFoundException('Unable to find Person.');
        }

        $deleteForm     = $this->createDeleteForm($id);

        $formHandler    = $this->get('black_person.person.form.handler');
        $process        = $formHandler->process($person);

        if ($process) {
            $manager->flush();

            return $this->redirect($this->generateUrl('admin_person_edit', array('id' => $id)));
        }

        return array(
            'document'      => $person,
            'form'          => $formHandler->getForm()->createView(),
            'delete_form'   => $deleteForm->createView()
        );
    }

    /**
     * Deletes a Person document.
     *
     * @param integer $id
     * @param string  $token
     * 
     * @Method({"POST", "GET"})
     * @Route("/{id}/delete/{token}", name="admin_person_delete")
     * @Secure(roles="ROLE_ADMIN")
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function deleteAction($id, $token = null)
    {
        $form       = $this->createDeleteForm($id);
        $request    = $this->getRequest();

        $form->bind($request);

        if (null !== $token) {
            $token = $this->get('form.csrf_provider')->isCsrfTokenValid('delete', $token);
        }

        if ($form->isValid() || true === $token) {

            $dm         = $this->getManager();
            $repository = $dm->getRepository();
            $document   = $repository->findOneById($id);

            if (!$document) {
                throw $this->createNotFoundException('Unable to find Person document.');
            }

            $userDocument = $this->get('black_user.manager.user')->findUserByPersonId($id);

            if ($userDocument) {
                $userDocument->setPerson(null);
                $dm->persist($userDocument);
            }

            $dm->remove($document);
            $dm->flush();

            $this->get('session')->getFlashBag()->add('success', 'success.person.admin.person.delete');

        } else {
            $this->get('session')->getFlashBag()->add('error', 'error.person.admin.person.not.valid');
        }

        return $this->redirect($this->generateUrl('admin_persons'));
    }

    /**
     * Deletes a Person document.
     *
     * @Method({"POST"})
     * @Route("/batch", name="admin_person_batch")
     *
     * @return array
     *
     * @throws \Symfony\Component\Serializer\Exception\InvalidArgumentException If method does not exist
     */
    public function batchAction()
    {
        $request    = $this->getRequest();
        $token      = $this->get('form.csrf_provider')->isCsrfTokenValid('batch', $request->get('token'));

        if (!$ids = $request->get('ids')) {
            $this->get('session')->getFlashBag()->add('error', 'error.person.admin.person.no.item');

            return $this->redirect($this->generateUrl('admin_persons'));
        }

        if (!$action = $request->get('batchAction')) {
            $this->get('session')->getFlashBag()->add('error', 'error.person.admin.person.no.action');

            return $this->redirect($this->generateUrl('admin_persons'));
        }

        if (!method_exists($this, $method = $action . 'Action')) {
            throw new Exception\InvalidArgumentException(
                sprintf('You must create a "%s" method for action "%s"', $method, $action)
            );
        }

        if (false === $token) {
            $this->get('session')->getFlashBag()->add('error', 'error.person.admin.person.crsf');

            return $this->redirect($this->generateUrl('admin_persons'));
        }

        foreach ($ids as $id) {
            $this->$method($id, $token);
        }

        return $this->redirect($this->generateUrl('admin_persons'));

    }

    protected function createDeleteForm($id)
    {
        $form = $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();

        return $form;
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    protected function getManager()
    {
        return $this->get('black_person.manager.person');
    }
}