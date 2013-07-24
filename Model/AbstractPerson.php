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

/**
 * Class AbstractPerson
 *
 * @package Black\Bundle\PersonBundle\Model
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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setAdditionalName($additionalName)
    {
        $this->additionalName = $additionalName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdditionalName()
    {
        return $this->additionalName;
    }

    /**
     * {@inheritdoc}
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * {@inheritdoc}
     */
    public function setBirthdate($birthdate)
    {
        $this->birthDate = $birthdate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBirthdate()
    {
        return $this->birthDate;
    }

    /**
     * {@inheritdoc}
     */
    public function getColleagues()
    {
        return $this->colleagues;
    }

    /**
     * {@inheritdoc}
     */
    public function setColleague($colleagues)
    {
        $this->colleagues[] = $colleagues;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addColleague(PersonInterface $person)
    {
        if (!$person->getColleagues()->contains($this)) {
            $person->setColleague($this);
        }

        $this->setColleague($person);
    }

    /**
     * {@inheritdoc}
     */
    public function removeColleague(PersonInterface $person)
    {
        if ($person->getColleagues()->contains($this)) {
            $person->getColleagues()->removeElement($this);
        }

        $this->getColleagues()->removeElement($person);
    }

    /**
     * {@inheritdoc}
     */
    public function setContactPoints($contactPoints)
    {
        $this->contactPoints = $contactPoints;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContactPoints()
    {
        return $this->contactPoints;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * {@inheritdoc}
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * {@inheritdoc}
     */
    public function setHonorificPrefix($honorificPrefix)
    {
        $this->honorificPrefix = $honorificPrefix;

        return $this;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function setHonorificSuffix($honorificSuffix)
    {
        $this->honorificSuffix = $honorificSuffix;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHonorificSuffix()
    {
        return $this->honorificSuffix;
    }

    /**
     * {@inheritdoc}
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * {@inheritdoc}
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function setChild($children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent($parents)
    {
        $this->parents[] = $parents;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(PersonInterface $person)
    {
        if (!$person->getParents()->contains($this)) {
            $person->setParent($this);
        }

        $this->children[] = $person;
    }

    /**
     * {@inheritdoc}
     */
    public function addParent(PersonInterface $person)
    {
        if (!$person->getChildren()->contains($this)) {
            $person->setChild($this);
        }

        $this->parents[] = $person;
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(PersonInterface $person)
    {
        if ($person->getParents()->contains($this)) {
            $person->getParents()->removeElement($this);
        }

        $this->children->removeElement($this);
    }

    /**
     * {@inheritdoc}
     */
    public function removeParent(PersonInterface $person)
    {
        if ($person->getChildren()->contains($this)) {
            $person->getChildren()->removeElement($this);
        }

        $this->parents->removeElement($this);
    }

    /**
     * {@inheritdoc}
     */
    public function setSeeks($seeks)
    {
        $this->seeks = $seeks;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSeeks()
    {
        return $this->seeks;
    }

    /**
     * {@inheritdoc}
     */
    public function setSibling($sibling)
    {
        $this->siblings[] = $sibling;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSiblings()
    {
        return $this->siblings;
    }

    /**
     * {@inheritdoc}
     */
    public function addSibling(PersonInterface $person)
    {
        if (!$person->getSiblings()->contains($this)) {
            $person->setSibling($this);
        }

        $this->setSibling($person);
    }

    /**
     * {@inheritdoc}
     */
    public function removeSibling(PersonInterface $person)
    {
        if ($person->getSiblings()->contains($this)) {
            $person->getSiblings()->removeElement($this);
        }

        $this->getSiblings()->removeElement($person);

    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getSpouse()
    {
        return $this->spouse;
    }

    /**
     * {@inheritdoc}
     */
    public function addSpouse(PersonInterface $person)
    {
        if (!$person->getSpouse()) {
            $person->setSpouse($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setWorksFor($worksFor)
    {
        $this->worksFor = $worksFor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorksFor()
    {
        return $this->worksFor;
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
        return __DIR__ . '/../../../../../../web/' . $this->getUploadDir();
    }

    /**
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/profile';
    }
    
    public function onRemove()
    {
    }
}
