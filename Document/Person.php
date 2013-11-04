<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PersonBundle\Document;

use Black\Bundle\CommonBundle\Traits\ImageDocumentTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Black\Bundle\CommonBundle\Traits\ThingDocumentTrait;
use Black\Bundle\PersonBundle\Model\AbstractPerson;

/**
 * Class Person
 *
 * @ODM\MappedSuperclass()
 *
 * @package Black\Bundle\PersonBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class Person extends AbstractPerson
{
    use ThingDocumentTrait;
    use ImageDocumentTrait;

    /**
     * @ODM\String
     * @Assert\Type(type="string")
     */
    protected $additionalName;

    /**
     * @ODM\EmbedMany(targetDocument="Black\Bundle\PersonBundle\Document\PostalAddress")
     */
    protected $address;

    /**
     * @ODM\Date
     */
    protected $birthDate;

    /**
     * @ODM\EmbedMany(targetDocument="Black\Bundle\PersonBundle\Document\ContactPoint")
     */
    protected $contactPoints;

    /**
     * @ODM\String
     * @ODM\UniqueIndex
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ODM\String
     * @Assert\Type(type="string")
     */
    protected $familyName;

    /**
     * @ODM\String
     */
    protected $gender;

    /**
     * @ODM\String
     * @Assert\Type(type="string")
     */
    protected $givenName;

    /**
     * @ODM\String
     */
    protected $honorificPrefix;

    /**
     * @ODM\String
     */
    protected $honorificSuffix;

    /**
     * @ODM\String
     * @Assert\Type(type="string")
     */
    protected $jobTitle;

    /**
     * @ODM\Field
     */
    protected $seeks;

    /**
     * @ODM\Field
     */
    protected $worksFor;

    /**
     * @param $name
     */
    public function setName($name)
    {
        if (null === $name) {
            $this->name = $this->getGivenName() . ' ' . $this->getFamilyName();
        }
    }
}
