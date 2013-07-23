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
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Black\Bundle\CommonBundle\Traits\ContactPointEntityTrait;
use Black\Bundle\CommonBundle\Entity\PostalAddress as AbstractPostalAddress;

/**
 * PostalAddress
 */
abstract class PostalAddress extends AbstractPostalAddress
{
}
