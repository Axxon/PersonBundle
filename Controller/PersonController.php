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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Black\Bundle\PersonBundle\Model\PersonInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class PersonController
 *
 * @Route("/person")
 *
 * @package Black\Bundle\PersonBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PersonController extends Controller
{
    /**
     * @Route("/me.html", name="person_me")
     * @Secure(roles="ROLE_USER")
     * @Template()
     *
     * @return array
     */
    public function meAction()
    {
        $user   = $this->getUser();
        $person = $user->getPerson();
        $new    = false;

        $personManager  = $this->getPersonManager();

        if (!is_object($person) || !$person instanceof PersonInterface) {
            $new    = true;
            $person = $personManager->createInstance();
            $person->setEmail($user->getEmail());
        }

        $formHandler    = $this->get('black_person.person.form.front_handler');
        $process        = $formHandler->process($person);

        if ($process) {
            return $this->redirect($formHandler->getUrl());
        }

        return array(
            'person'    => $person,
            'form'      => $formHandler->getForm()->createView(),
        );
    }

    /**
     * @return DocumentManager
     */
    protected function getPersonManager()
    {
        return $this->get('black_person.manager.person');
    }
}
