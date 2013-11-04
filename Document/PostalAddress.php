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

use Black\Bundle\CommonBundle\Traits\PostalAddressDocumentTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Black\Bundle\CommonBundle\Document\PostalAddress as AbstractPostalAddress;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class PostalAddress
 *
 * @ODM\EmbeddedDocument
 *
 * @package Black\Bundle\PersonBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PostalAddress
{
    use PostalAddressDocumentTrait;
}
