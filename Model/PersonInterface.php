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
 * Class PersonInterface
 *
 * @package Black\Bundle\PersonBundle\Model
 */
interface PersonInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getAdditionalName();

    /**
     * @return mixed
     */
    public function getAddress();

    /**
     * @return mixed
     */
    public function getBirthdate();

    /**
     * @return mixed
     */
    public function getChildren();

    /**
     * @return mixed
     */
    public function getColleagues();

    /**
     * @return mixed
     */
    public function getContactPoints();

    /**
     * @return mixed
     */
    public function getDescription();

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @return mixed
     */
    public function getFamilyName();

    /**
     * @return mixed
     */
    public function getGender();

    /**
     * @return mixed
     */
    public function getGivenName();

    /**
     * @return mixed
     */
    public function getHonorificPrefix();

    /**
     * @return mixed
     */
    public function getHonorificSuffix();

    /**
     * @return mixed
     */
    public function getImage();

    /**
     * @return mixed
     */
    public function getJobTitle();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getParents();

    /**
     * @return mixed
     */
    public function getSeeks();

    /**
     * @return mixed
     */
    public function getSiblings();

    /**
     * @return mixed
     */
    public function getSlug();

    /**
     * @return mixed
     */
    public function getSpouse();

    /**
     * @return mixed
     */
    public function getUrl();

    /**
     * @return mixed
     */
    public function getWorksFor();
}
