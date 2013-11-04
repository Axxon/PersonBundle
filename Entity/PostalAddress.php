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

use Black\Bundle\CommonBundle\Traits\ContactPointEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Black\Bundle\CommonBundle\Traits\PostalAddressEntityTrait;

/**
 * Class PostalAddress
 *
 * @package Black\Bundle\PersonBundle\Entity
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PostalAddress
{
    use PostalAddressEntityTrait;
}
