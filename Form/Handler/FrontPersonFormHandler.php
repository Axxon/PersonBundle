<?php

/*
 * This file is part of the Blackperson package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PersonBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Black\Bundle\PersonBundle\Model\PersonInterface;

/**
 * Class FrontPersonFormHandler
 *
 * @package Black\Bundle\PersonBundle\Form\Handler
 */
class FrontPersonFormHandler
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;

    /**
     * @var
     */
    protected $factory;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * @param FormInterface    $form
     * @param Request          $request
     * @param SessionInterface $session
     */
    public function __construct(FormInterface $form, Request $request, SessionInterface $session)
    {
        $this->form     = $form;
        $this->request  = $request;
        $this->session  = $session;
    }

    public function process(PersonInterface $person)
    {
        $this->form->setData($person);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            $person->setName(null);

            if ($this->form->isValid()) {
                $person->upload();

                $this->setFlash('success', 'success.person.www.person.edit');

                return true;
            } else {
                $this->setFlash('error', 'error.person.www.person.edit');
            }
        }
    }

    public function getForm()
    {
        return $this->form;
    }

    protected function setFlash($name, $msg)
    {
        return $this->session->getFlashBag()->add($name, $msg);
    }
}
