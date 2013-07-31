<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PersonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use Black\Bundle\PersonBundle\Model\AbstractPerson;
use Black\Bundle\CommonBundle\Traits\ThingEntityTrait;

/**
 * Person Entity
 */
abstract class Person extends AbstractPerson
{
    use ThingEntityTrait;

    /**
     * @ORM\Column(name="additional_name", type="string", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $additionalName;

    /**
     * @ORM\ManyToMany(targetEntity="PostalAddress", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="person_postal_address",
     *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="postal_address_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    protected $address;

    /**
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    protected $birthDate;

    /**
     * @ORM\ManyToMany(targetEntity="Person", mappedBy="parents", cascade={"persist", "remove"})
     */
    protected $children;

    /**
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="children", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="person_parent",
     *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")}
     *      )
     */
    protected $parents;

    /**
     * @ORM\ManyToMany(targetEntity="Person", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="person_colleague",
     *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="colleague_id", referencedColumnName="id")}
     *      )
     */
    protected $colleagues;

    /**
     * @ORM\ManyToMany(targetEntity="ContactPoint", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="person_contact_point",
     *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="contact_point_id", referencedColumnName="id", unique=true, onDelete="CASCADE")}
     *      )
     */
    protected $contactPoints;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\Column(name="familly_name", type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    protected $familyName;

    /**
     * @ORM\Column(name="gender", type="string", length=255, nullable=true)
     */
    protected $gender;

    /**
     * @ORM\Column(name="given_name", type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     */
    protected $givenName;

    /**
     * @ORM\Column(name="honorific_prefix", type="string", length=255, nullable=true)
     */
    protected $honorificPrefix;

    /**
     * @ORM\Column(name="honorifix_suffix", type="string", length=255, nullable=true)
     */
    protected $honorificSuffix;

    /**
     * @ORM\Column(name="image", type="blob", nullable=true)
     * @Assert\Image(maxSize="2M")
     */
    protected $image;

    /**
     * @ORM\Column(name="job_title", type="string", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $jobTitle;

    /**
     * @ORM\Column(name="path", type="string", nullable=true)
     */
    protected $path;

    /**
     * @ORM\Column(name="seeks", type="string", nullable=true)
     */
    protected $seeks;

    /**
     * @ORM\ManyToMany(targetEntity="Person", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="person_sibling",
     *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="sibling_id", referencedColumnName="id")}
     *      )
     */
    protected $siblings;

    /**
     * @ORM\OneToOne(targetEntity="Person", cascade={"persist", "remove"})
     */
    protected $spouse;

    /**
     * @ORM\Column(name="work_for", type="string", nullable=true)
     */
    protected $worksFor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->siblings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->colleagues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->seeks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        if (null === $name) {
            $this->name = $this->getGivenName() . ' ' . $this->getFamilyName();
        }
    }

    /**
     * upload
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
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($image = $this->getAbsolutePath()) {
            unlink($image);
        }
    }

    /**
     * @ORM\PreRemove
     */
    public function onRemove()
    {
    }
}
