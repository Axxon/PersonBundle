<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PersonBundle\Form\ChoiceList;

use Black\Bundle\PersonBundle\Model\PersonManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * PersonList
 */
class PersonList extends LazyChoiceList
{
    /**
     * @var PersonManagerInterface
     */
    private $manager;

    /**
     * @param PersonManagerInterface $manager
     */
    public function __construct(PersonManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface|SimpleChoiceList
     */
    protected function loadChoiceList()
    {
        $choices    = array();
        $persons    = $this->getPersons();
        $choices += array('other' => 'person.admin.person.choice.other.text');

        foreach ($persons as $person) {
            $choices += array($person->getId() => $person->getName());
        }
        $choices = new SimpleChoiceList($choices);

        return $choices;
    }

    /**
     * @return mixed
     */
    protected function getPersons()
    {
        $persons = $this->manager->findPersons();

        return $persons;
    }
}
