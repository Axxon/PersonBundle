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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ContactType
 *
 * @package Black\Bundle\PersonBundle\Form\Type
 */
class ContactType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add(
                'value',
                'textarea',
                array(
                    'label' => ' ',
                    "attr"  => array(
                        "rows" => 5
                    )
                )
            )
            ->add(
                'to',
                'hidden',
                array(
                    'data'  => $options['data']['id']
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
                'data_class'    => null,
                'intention'     => 'contact_form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_person_contact';
    }
}
