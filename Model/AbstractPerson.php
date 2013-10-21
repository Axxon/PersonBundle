<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PersonBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AbstractPerson
 *
 * @package Black\Bundle\PersonBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class AbstractPerson implements PersonInterface
{
    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $additionalName;

    /**
     * @var
     */
    protected $address;

    /**
     * @var
     */
    protected $birthDate;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $children;

    /**
     * @var
     */
    protected $colleagues;

    /**
     * @var
     */
    protected $contactPoints;

    /**
     * @var
     */
    protected $email;

    /**
     * @var
     */
    protected $familyName;

    /**
     * @var
     *
     * @Assert\Choice(callback = "getGenders")
     */
    protected $gender;

    /**
     * @var
     */
    protected $givenName;

    /**
     * @var
     *
     * @Assert\Choice(callback = "getHonorificPrefixes")
     */
    protected $honorificPrefix;

    /**
     * @var
     */
    protected $honorificSuffix;

    /**
     * @var
     */
    protected $image;

    /**
     * @var
     */
    protected $jobTitle;

    /**
     * @var
     */
    protected $path;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $parents;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $seeks;

    /**
     * @var
     */
    protected $siblings;

    /**
     * @var
     */
    protected $spouse;

    /**
     * @var
     */
    protected $worksFor;

    /**
     * @var
     */
    protected $temp;

    /**
     *
     */
    public function __construct()
    {
        $this->children     = new ArrayCollection();
        $this->parents      = new ArrayCollection();
        $this->seeks        = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $additionalName
     *
     * @return $this
     */
    public function setAdditionalName($additionalName)
    {
        $this->additionalName = $additionalName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdditionalName()
    {
        return $this->additionalName;
    }

    /**
     * @param $address
     *
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param $birthdate
     *
     * @return $this
     */
    public function setBirthdate($birthdate)
    {
        $this->birthDate = $birthdate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthDate;
    }

    /**
     * @return mixed
     */
    public function getColleagues()
    {
        return $this->colleagues;
    }

    /**
     * @param $colleagues
     *
     * @return $this
     */
    public function setColleague($colleagues)
    {
        $this->colleagues[] = $colleagues;

        return $this;
    }

    /**
     * @param PersonInterface $person
     */
    public function addColleague(PersonInterface $person)
    {
        if (!$person->getColleagues()->contains($this)) {
            $person->setColleague($this);
        }

        $this->setColleague($person);
    }

    /**
     * @param PersonInterface $person
     */
    public function removeColleague(PersonInterface $person)
    {
        if ($person->getColleagues()->contains($this)) {
            $person->getColleagues()->removeElement($this);
        }

        $this->getColleagues()->removeElement($person);
    }

    /**
     * @param $contactPoints
     *
     * @return $this
     */
    public function setContactPoints($contactPoints)
    {
        $this->contactPoints = $contactPoints;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactPoints()
    {
        return $this->contactPoints;
    }

    /**
     * @param $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $familyName
     *
     * @return $this
     */
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * @param $gender
     *
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return array
     */
    public static function getGenders()
    {
        return array('M', 'F');
    }

    /**
     * @param $givenName
     *
     * @return $this
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * @param $honorificPrefix
     *
     * @return $this
     */
    public function setHonorificPrefix($honorificPrefix)
    {
        $this->honorificPrefix = $honorificPrefix;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHonorificPrefix()
    {
        return $this->honorificPrefix;
    }

    /**
     * @return array
     */
    public static function getHonorificPrefixes()
    {
        return array('Mr', 'Miss', 'Mrs', 'Pr', 'Dr');
    }

    /**
     * @param $honorificSuffix
     *
     * @return $this
     */
    public function setHonorificSuffix($honorificSuffix)
    {
        $this->honorificSuffix = $honorificSuffix;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHonorificSuffix()
    {
        return $this->honorificSuffix;
    }

    /**
     * @param UploadedFile $image
     *
     * @return $this
     */
    public function setImage(UploadedFile $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $jobTitle
     *
     * @return $this
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * @param $children
     *
     * @return $this
     */
    public function setChild($children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * @param $parents
     *
     * @return $this
     */
    public function setParent($parents)
    {
        $this->parents[] = $parents;

        return $this;
    }

    /**
     * @return ArrayCollection|mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return ArrayCollection|mixed
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param PersonInterface $person
     */
    public function addChild(PersonInterface $person)
    {
        if (!$person->getParents()->contains($this)) {
            $person->setParent($this);
        }

        $this->children[] = $person;
    }

    /**
     * @param PersonInterface $person
     */
    public function addParent(PersonInterface $person)
    {
        if (!$person->getChildren()->contains($this)) {
            $person->setChild($this);
        }

        $this->parents[] = $person;
    }

    /**
     * @param PersonInterface $person
     */
    public function removeChild(PersonInterface $person)
    {
        if ($person->getParents()->contains($this)) {
            $person->getParents()->removeElement($this);
        }

        $this->children->removeElement($this);
    }

    /**
     * @param PersonInterface $person
     */
    public function removeParent(PersonInterface $person)
    {
        if ($person->getChildren()->contains($this)) {
            $person->getChildren()->removeElement($this);
        }

        $this->parents->removeElement($this);
    }

    /**
     * @param $seeks
     *
     * @return $this
     */
    public function setSeeks($seeks)
    {
        $this->seeks = $seeks;

        return $this;
    }

    /**
     * @return ArrayCollection|mixed
     */
    public function getSeeks()
    {
        return $this->seeks;
    }

    /**
     * @param $sibling
     *
     * @return $this
     */
    public function setSibling($sibling)
    {
        $this->siblings[] = $sibling;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSiblings()
    {
        return $this->siblings;
    }

    /**
     * @param PersonInterface $person
     */
    public function addSibling(PersonInterface $person)
    {
        if (!$person->getSiblings()->contains($this)) {
            $person->setSibling($this);
        }

        $this->setSibling($person);
    }

    /**
     * @param PersonInterface $person
     */
    public function removeSibling(PersonInterface $person)
    {
        if ($person->getSiblings()->contains($this)) {
            $person->getSiblings()->removeElement($this);
        }

        $this->getSiblings()->removeElement($person);
    }

    /**
     * @param $spouse
     *
     * @return $this
     */
    public function setSpouse($spouse)
    {
        $this->spouse = $spouse;

        if ($spouse) {
            $this->addSpouse($spouse);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpouse()
    {
        return $this->spouse;
    }

    /**
     * @param PersonInterface $person
     */
    public function addSpouse(PersonInterface $person)
    {
        if (!$person->getSpouse()) {
            $person->setSpouse($this);
        }
    }

    /**
     * @param $worksFor
     *
     * @return $this
     */
    public function setWorksFor($worksFor)
    {
        $this->worksFor = $worksFor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorksFor()
    {
        return $this->worksFor;
    }

    /**
     * @return PostalAddress
     */
    public function getFirstFormattedAddress()
    {
        if ($this->getAddress()->first()) {
            return $this->getAddress()->first()->getAddress();
        }
    }

    /**
     *
     */
    public function upload()
    {
        if (null == $this->image) {
            return;
        }

        $this->image->move($this->getUploadRootDir(), $this->image->getClientOriginalName());
        $this->path = $this->image->getClientOriginalName();
        $this->image = null;
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../web/' . $this->getUploadDir();
    }

    /**
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/profile';
    }

    /**
     *
     */
    public function onRemove()
    {
    }
}
