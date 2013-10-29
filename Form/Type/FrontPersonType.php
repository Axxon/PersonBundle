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
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class FrontPersonType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param string              $class
     */
    public function __construct($class)
    {
        $this->class        = $class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', 'black_person_choice_list_gender', array(
                    'label'         => 'person.www.person.gender.text',
                    'empty_value'   => 'person.www.person.gender.choice'
                )
            )

            ->add('givenName', 'text', array(
                    'label'         => 'person.www.person.name.given.text'
                )
            )
            ->add('familyName', 'text', array(
                    'label'         => 'person.www.person.name.family.text'
                )
            )

            ->add('birthdate', 'date', array(
                    'years'         => array_reverse(
                        range(1900, date('Y', strtotime('now')))
                    ),
                    'label'         => 'person.www.person.birthdate.text',
                    'required'      => false,
                    'empty_value'   => array(
                        'year'  => 'person.www.person.birthdate.year.empty',
                        'month' => 'person.www.person.birthdate.month.empty',
                        'day'   => 'person.www.person.birthdate.day.empty')
                )
            )
            ->add('image', 'file', array(
                    'label'         => 'person.www.person.image.text',
                    'required'      => false,
                    'image_path'    => 'webPath'
                )
            )
            ->add('email', 'email', array(
                    'label'         => 'person.www.person.email.text'
                )
            )
            ->add('url', 'url', array(
                    'required'      => false,
                    'label'         => 'person.www.person.url.text'
                )
            )

            ->add('description', 'textarea', array(
                    'required'      => false,
                    'label'         => 'person.www.person.description.text',
                    'attr'          => array(
                        'rows'          => '10',
                        'class'         => 'span12',
                        'placeholder'   => 'person.www.person.description.placeholder'
                    )
                )
            )
            ->add('save', 'submit', array(
                    'label'     => 'black.person.type.button.save.label',
                    'attr'      => array(
                        'class'     => 'btn btn-success pull-right m20'
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
                'data_class'            => $this->class,
                'intention'             => 'front_person_form',
                'translation_domain'    => 'form'
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
