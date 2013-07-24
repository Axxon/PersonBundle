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

/**
 * Class FrontPersonType
 *
 * @package Black\Bundle\PersonBundle\Form\Type
 */
class FrontPersonType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var
     */
    private $postalType;

    /**
     * @var
     */
    private $contactType;

    /**
     * @var \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface
     */
    private $gender;

    /**
     * @param string              $class
     * @param PostalAddressType   $postal
     * @param ContactPointType    $contact
     * @param ChoiceListInterface $gender
     */
    public function __construct(
        $class,
        PostalAddressType $postal,
        ContactPointType $contact,
        ChoiceListInterface $gender
    )
    {
        $this->class        = $class;
        $this->postalType   = $postal;
        $this->contactType  = $contact;
        $this->gender       = $gender;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'gender',
                'choice',
                array(
                    'label'         => 'person.www.person.gender.text',
                    'empty_value'   => 'person.www.person.gender.choice',
                    'choice_list'   => $this->gender
                )
            )

            ->add(
                'givenName',
                'text',
                array(
                    'label'         => 'person.www.person.name.given.text'
                )
            )
            ->add(
                'familyName',
                'text',
                array(
                    'label'         => 'person.www.person.name.family.text'
                )
            )

            ->add(
                'birthdate',
                'date',
                array(
                    'years'         => array_reverse(
                        range(1900, date('Y', strtotime('now')))
                    ),
                    'label'         => 'person.www.person.birthdate.text',
                    'required'      => false,
                    'empty_value'   => array(
                        'year' => 'person.www.person.birthdate.year.empty',
                        'month' => 'person.www.person.birthdate.month.empty',
                        'day' => 'person.www.person.birthdate.day.empty')
                )
            )
            ->add(
                'image',
                'file',
                array(
                    'label'         => 'person.www.person.image.text',
                    'required'      => false
                )
            )
            ->add(
                'email',
                'email',
                array(
                    'label'         => 'person.www.person.email.text'
                )
            )
            ->add(
                'url',
                'url',
                array(
                    'required'      => false,
                    'label'         => 'person.www.person.url.text'
                )
            )

            ->add(
                'description',
                'textarea',
                array(
                    'required'      => false,
                    'label'         => 'person.www.person.description.text',
                    'attr'          => array(
                        'rows'          => 20,
                        'style'         => 'width:100%;',
                        'placeholder'   => 'person.www.person.description.placeholder'
                    )
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
                'intention'     => 'front_person_form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_person_front_person';
    }
}
