<?php

namespace Black\Bundle\PersonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Black\Bundle\PersonBundle\Model\PersonInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/me.html", name="profile_me")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function meAction()
    {
        $user   = $this->getUser();
        $person = $user->getPerson();
        $new    = false;

        $userManager    = $this->getUserManager();
        $personManager  = $this->getPersonManager();

        if (!is_object($person) || !$person instanceof PersonInterface) {
            $new    = true;
            $person = $personManager->createInstance();
        }

        $formHandler    = $this->get('black_person.person.form.front_handler');
        $process        = $formHandler->process($person);

        if ($process) {
            $personManager->persist($person);

            if (true === $new) {
                $user->setPerson($person);
                $userManager->persist($user);
            }

            $userManager->flush();

            return $this->redirect($this->generateUrl('profile_me'));
        }

        return array(
            'person'    => $person,
            'form'      => $formHandler->getForm()->createView(),
        );
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    protected function getPersonManager()
    {
        return $this->get('black_person.manager.person');
    }

    /**
     * Returns the User Manager
     *
     * @return DocumentManager
     */
    protected function getUserManager()
    {
        return $this->get('black_user.manager.user');
    }
}
