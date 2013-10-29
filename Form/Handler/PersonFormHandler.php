<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PersonBundle\Form\Handler;

use Black\Bundle\PersonBundle\Model\PersonManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Black\Bundle\PersonBundle\Model\PersonInterface;
use Black\Bundle\PageBundle\Model\PageManagerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class PersonFormHandler
 *
 * @package Black\Bundle\PersonBundle\Form\Handler
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PersonFormHandler
{
    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;

    /**
     * @var
     */
    protected $factory;

    /**
     * @var \Black\Bundle\PersonBundle\Model\PersonManagerInterface
     */
    protected $personManager;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securiyContext;

    /**
     * @var
     */
    protected $url;

    /**
     * @param FormInterface          $form
     * @param PersonManagerInterface $personManager
     * @param Request                $request
     * @param Router                 $router
     * @param SessionInterface       $session
     */
    public function __construct(FormInterface $form, PersonManagerInterface $personManager, Request $request, Router $router, SessionInterface $session, SecurityContextInterface $securityContext)
    {
        $this->form             = $form;
        $this->personManager    = $personManager;
        $this->request          = $request;
        $this->router           = $router;
        $this->session          = $session;
        $this->securiyContext   = $securityContext;
    }

    /**
     * @param PersonInterface $person
     *
     * @return bool
     */
    public function process(PersonInterface $person)
    {
        $this->form->setData($person);

        if ('POST' === $this->request->getMethod()) {
            $this->form->handleRequest($this->request);

            $person->setName(null);

            if ($this->form->isValid()) {

                return $this->onSave($person);
            } else {
                return $this->onFailed();
            }
        }
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param PersonInterface $page
     *
     * @return mixed
     */
    protected function onSave(PersonInterface $person)
    {
        if (!$person->getId()) {
            $this->personManager->persist($person);
        }

        $this->personManager->flush();

        if ($this->form->get('save')->isClicked()) {
            $this->setFlash('success', 'success.person.www.person.edit');
            $this->setUrl($this->generateUrl('admin_person_edit', array('id' => $person->getId())));

            return true;
        }

        if ($this->form->get('saveAndAdd')->isClicked()) {
            $this->setUrl($this->generateUrl('admin_page_new'));

            return true;
        }
    }

    /**
     * @return bool
     */
    protected function onFailed()
    {
        $this->setFlash('error', 'error.person.www.person.edit');

        return false;
    }

    /**
     * @param $name
     * @param $msg
     * @return mixed
     */
    protected function setFlash($name, $msg)
    {
        return $this->session->getFlashBag()->add($name, $msg);
    }

    /**
     * @param       $route
     * @param array $parameters
     * @param       $referenceType
     *
     * @return mixed
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->router->generate($route, $parameters, $referenceType);
    }
}
