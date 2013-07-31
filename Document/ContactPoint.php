<?php

/*
 * This file is part of the Blackperson package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PersonBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Black\Bundle\CommonBundle\Traits\ContactPointDocumentTrait;

/**
 * ContactPoint Document
 *
 * @ODM\EmbeddedDocument
 */
class ContactPoint
{
    use ContactPointDocumentTrait;
}