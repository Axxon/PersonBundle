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
 * Class ContactPointType
 *
 * @package Black\Bundle\PersonBundle\Form\Type
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ContactPointType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface
     */
    protected $contact;

    /**
     * @param                     $class
     * @param ChoiceListInterface $contact
     */
    public function __construct($class, ChoiceListInterface $contact)
    {
        $this->class    = $class;
        $this->contact  = $contact;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contactType', 'choice', array(
                    'empty_value'       => 'person.admin.contactPoint.type.empty',
                    'label'             => 'person.admin.contactPoint.type.text',
                    'choice_list'       => $this->contact
                )
            )
            ->add('email', 'text', array(
                    'label'         => 'person.admin.contactPoint.email.text',
                    'required'      => false
                )
            )
            ->add('telephone', 'text', array(
                    'label'         => 'person.admin.contactPoint.phone.text',
                    'required'      => false
                )
            )
            ->add('mobile', 'text', array(
                    'label'         => 'person.admin.contactPoint.mobile.text',
                    'required'      => false
                )
            )
            ->add('faxNumber', 'text', array(
                    'label'         => 'person.admin.contactPoint.fax.text',
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
                'data_class'            => $this->class,
                'intention'             => 'contactpoint_form',
                'translation_domaine'   => 'form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_person_contactpoint';
    }
}
