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

/**
 * Class AbstractContactPoint
 *
 * @package Black\Bundle\PersonBundle\Model
 */
abstract class AbstractContactPoint implements ContactPointInterface
{
    /**
     * @var Integer
     */
    protected $id;

    /**
     * @var String
     */
    protected $contactType;

    /**
     * @var String
     */
    protected $email;

    /**
     * @var String
     */
    protected $faxNumber;

    /**
     * @var String
     */
    protected $telephone;

    /**
     * @var String
     */
    protected $mobile;

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
    public function setContactType($contactType)
    {
        $this->contactType = $contactType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContactType()
    {
        return $this->contactType;
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
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * {@inheritdoc}
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMobile()
    {
        return $this->mobile;
    }
}
