<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PersonBundle\Form\EventListener;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Black\Bundle\PersonBundle\Model\PersonRepositoryInterface;

/**
 * Class SetPersonDataSubscriber
 *
 * @package Black\Bundle\PersonBundle\Form\EventListener
 */
class SetPersonDataSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    private $factory;
    
    /**
     * @var
     */
    private $dbDriver;

    /**
     * @var
     */
    private $class;

    /**
     * @param FormFactoryInterface $factory
     * @param                      $dbDriver
     * @param                      $class
     */
    public function __construct(FormFactoryInterface $factory, $dbDriver, $class)
    {
        $this->factory = $factory;
        $this->dbDriver = $dbDriver;
        $this->class = $class;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (!$data) {
            return;
        }

        $this->addSpouse($data, $form);
    }

    /**
     * @param $data
     * @param $form
     */
    private function addSpouse($data, $form)
    {
        if ($data && !$data->getId()) {
            $form->add(
                $this->factory->createNamed(
                    'spouse',
                    ($this->dbDriver=='mongodb') ? 'document' : 'entity',
                    null,
                    array(
                        'label'         => 'person.admin.setPersonData.spouse.text',
                        'class'         => $this->class,
                        'property'      => 'name',
                        'required'      => false,
                        'auto_initialize'=> false,
                        'empty_value'   => 'person.admin.setPersonData.spouse.empty'
                    )
                )
            );
        }

        if ($data && $data->getId()) {
            $form->add(
                $this->factory->createNamed(
                    'spouse',
                    ($this->dbDriver == 'mongodb') ? 'document' : 'entity',
                    null,
                    array(
                        'label'         => 'person.admin.setPersonData.spouse.text',
                        'class'         => $this->class,
                        'property'      => 'name',
                        'query_builder' => function (PersonRepositoryInterface $pr) use ($data) {
                            return $pr->getAllExcept($data->getId());
                        },
                        'required'      => false,
                        'auto_initialize'=> false,
                        'empty_value'   => 'person.admin.setPersonData.spouse.empty',
                        'data'          => $data->getSpouse() ? $data->getSpouse()->getId() : null
                    )
                )
            );
        }
    }
}
