<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PersonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Black\Bundle\PersonBundle\Form\EventListener\SetPersonDataSubscriber;
use Black\Bundle\CommonBundle\Form\Type\PostalAddressType;

/**
 * Class PersonType
 *
 * @package Black\Bundle\PersonBundle\Form\Type
 */
class PersonType extends AbstractType
{
    /**
     * @var string
     */
    protected $dbDriver;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var
     */
    protected $postalType;

    /**
     * @var
     */
    protected $contactType;

    /**
     * @var \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface
     */
    protected $gender;

    /**
     * @var \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface
     */
    protected $honorific;

    /**
     * @param string                                                                $dbDriver
     * @param string                                                                $class
     * @param \Black\Bundle\PersonBundle\Form\Type\PostalAddressType                $postal
     * @param \Black\Bundle\PersonBundle\Form\Type\ContactPointType                 $contact
     * @param \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface $gender
     * @param \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface $honorific
     */
    public function __construct(
        $dbDriver,
        $class,
        PostalAddressType $postal,
        ContactPointType $contact,
        ChoiceListInterface $gender,
        ChoiceListInterface $honorific
    )
    {
        $this->dbDriver     = $dbDriver;
        $this->class        = $class;
        $this->postalType   = $postal;
        $this->contactType  = $contact;
        $this->gender       = $gender;
        $this->honorific    = $honorific;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new SetPersonDataSubscriber($builder->getFormFactory(), $this->dbDriver, $this->class);
        $builder->addEventSubscriber($subscriber);

        $builder
            ->add(
                'gender',
                'choice',
                array(
                    'label'         => 'person.admin.person.gender.text',
                    'empty_value'   => 'person.admin.person.gender.empty',
                    'choice_list'   => $this->gender
                )
            )
            ->add(
                'honorificPrefix',
                'choice',
                array(
                    'label'         => 'person.admin.person.honorificPrefix.text',
                    'required'      => false,
                    'empty_value'   => 'person.admin.person.honorificPrefix.empty',
                    'choice_list'   => $this->honorific
                )
            )
            ->add(
                'givenName',
                'text',
                array(
                    'label'         => 'person.admin.person.name.given.text'
                )
            )
            ->add(
                'additionalName',
                'text',
                array(
                    'label'         => 'person.admin.person.name.additional.text',
                    'required'      => false
                )
            )
            ->add(
                'familyName',
                'text',
                array(
                    'label'         => 'person.admin.person.name.family.text'
                )
            )
            ->add(
                'birthdate',
                'date',
                array(
                    'label'         => 'person.admin.person.birthdate.text',
                    'years'         => array_reverse(
                        range(1900, date('Y', strtotime('now')))
                    ),
                    'required'      => false,
                    'empty_value'   => array(
                        'year' => 'person.admin.person.birthdate.year.empty',
                        'month' => 'person.admin.person.birthdate.month.empty',
                        'day' => 'person.admin.person.birthdate.day.empty')
                )
            )
            ->add(
                'image',
                'file',
                array(
                    'label'         => 'person.admin.person.image.text',
                    'required'      => false
                )
            )

            ->add(
                'email',
                'email',
                array(
                    'label'         => 'person.admin.person.email.text'
                )
            )
            ->add(
                'url',
                'url',
                array(
                    'label'         => 'person.admin.person.url.text',
                    'required'      => false
                )
            )

            ->add(
                'contactPoints',
                'collection',
                array(
                    'type'          => $this->contactType,
                    'label'         => 'person.admin.person.contact.text',
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'required'      => false,
                    'attr'          => array(
                        'class' => 'contact-collection',
                        'add'   => 'add-another-contactPoint'
                    ),
                )
            )

            ->add(
                'address',
                'collection',
                array(
                    'type'          => $this->postalType,
                    'label'         => 'person.admin.person.address.text',
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'required'      => false,
                    'attr'          => array(
                        'class' => 'address-collection',
                        'add'   => 'add-another-address'
                    ),
                )
            )

            ->add(
                'jobTitle',
                'text',
                array(
                    'label'         => 'person.admin.person.job.text',
                    'required'      => false
                )
            )
            ->add(
                'worksFor',
                'text',
                array(
                    'label'         => 'person.admin.person.works.text',
                    'required'      => false
                )
            );
        if ($this->dbDriver === 'mongodb') {
            $builder
                ->add(
                    'children',
                    'document',
                    array(
                        'label'         => 'person.admin.person.children.text',
                        'class'         => $this->class,
                        'property'      => 'name',
                        'multiple'      => true,
                        'by_reference'  => false,
                        'required'      => false
                    )
                )
                ->add(
                    'parents',
                    'document',
                    array(
                        'label'         => 'person.admin.person.parent.text',
                        'class'         => $this->class,
                        'property'      => 'name',
                        'multiple'      => true,
                        'by_reference'  => false,
                        'required'      => false
                    )
                )
                ->add(
                    'colleagues',
                    'document',
                    array(
                        'label'         => 'person.admin.person.colleagues.text',
                        'class'         => $this->class,
                        'property'      => 'name',
                        'multiple'      => true,
                        'by_reference'  => false,
                        'required'      => false
                    )
                )
                ->add(
                    'siblings',
                    'document',
                    array(
                        'label'         => 'person.admin.person.siblings.text',
                        'class'         => $this->class,
                        'property'      => 'name',
                        'multiple'      => true,
                        'by_reference'  => false,
                        'required'      => false
                    )
                );
        } elseif ($this->dbDriver === 'mysql') {
            $builder
                ->add(
                    'children',
                    'entity',
                    array(
                        'label'         => 'person.admin.person.children.text',
                        'class'         => $this->class,
                            'property'      => 'name',
                            'multiple'      => true,
                            'required'      => false
                        )
                )
                ->add(
                    'parents',
                    'entity',
                    array(
                        'label'         => 'person.admin.person.parent.text',
                        'class'         => $this->class,
                        'property'      => 'name',
                        'multiple'      => true,
                        'required'      => false
                    )
                )
                ->add(
                    'colleagues',
                    'entity',
                    array(
                        'label'         => 'person.admin.person.colleagues.text',
                        'class'         => $this->class,
                        'property'      => 'name',
                        'multiple'      => true,
                        'required'      => false
                    )
                )
                ->add(
                    'siblings',
                    'entity',
                    array(
                        'label'         => 'person.admin.person.siblings.text',
                        'class'         => $this->class,
                        'property'      => 'name',
                        'multiple'      => true,
                        'required'      => false
                    )
                );
        }
        $builder->add(
            'description',
            'textarea',
            array(
                'label'         => 'person.admin.person.description.text',
                'required'      => false
            )
        )
        ->add(
            'seeks',
            'text',
            array(
                'label'         =>'person.admin.person.seeks.text',
                'required'      => false
            )
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'    => $this->class,
                'intention'     => 'person_form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_person_person';
    }
}
