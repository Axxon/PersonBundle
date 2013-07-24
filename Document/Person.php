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

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Black\Bundle\PersonBundle\Model\AbstractPerson;
use Gedmo\Mapping\Annotation as Gedmo;
use Black\Bundle\CommonBundle\Traits\ThingDocumentTrait;

/**
 * Person Document
 *
 * @ODM\MappedSuperclass()
 */
class Person extends AbstractPerson
{
    use ThingDocumentTrait;

    /**
     * @ODM\String
     * @Assert\Type(type="string")
     */
    protected $additionalName;

    /**
     * @ODM\EmbedMany(targetDocument="PostalAddress")
     */
    protected $address;

    /**
     * @ODM\Date
     */
    protected $birthDate;

    /**
     * @ODM\ReferenceMany(targetDocument="Person", mappedBy="parents", cascade={"persist", "remove"})
     */
    protected $children;

    /**
     * @ODM\ReferenceMany(targetDocument="Person", cascade={"persist", "remove"})
     */
    protected $colleagues;

    /**
     * @ODM\EmbedMany(targetDocument="ContactPoint")
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
     * @Assert\Image(maxSize="2M")
     */
    protected $image;

    /**
     * @ODM\String
     * @Assert\Type(type="string")
     */
    protected $jobTitle;

    /**
     * @ODM\String
     */
    protected $path;

    /**
     * @ODM\ReferenceMany(targetDocument="Person", inversedBy="children", cascade={"persist", "remove"})
     */
    protected $parents;

    /**
     * @ODM\Field
     */
    protected $seeks;

    /**
     * @ODM\ReferenceMany(targetDocument="Person", cascade={"persist", "remove"})
     */
    protected $siblings;

    /**
     * @ODM\ReferenceOne(targetDocument="Person", cascade={"persist", "remove"})
     */
    protected $spouse;

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

    /**
     *
     */
    public function upload()
    {
        if (null === $this->image) {
            return;
        }

        $this->path = sha1(uniqid(mt_rand(), true)) . '.' . $this->image->guessExtension();
        $this->image->move($this->getUploadRootDir(), $this->path);

        unset($this->image);
    }

    /**
     * @ODM\PostRemove()
     */
    public function removeUpload()
    {
        if ($image = $this->getAbsolutePath()) {
            unlink($image);
        }
    }
    
    /**
     * @ODM\PreRemove
     */
    public function onRemove()
    {
    }
}
