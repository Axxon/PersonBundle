<?php

/*
 * This file is part of the Blackperson package.
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
use Black\Bundle\CommonBundle\Traits\ContactPointEntityTrait;

/**
 * ContactPoint
 */
abstract class ContactPoint
{
    use ContactPointEntityTrait;
}
