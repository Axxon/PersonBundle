<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PersonBundle\Form\ChoiceList;

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * Class HonorificPrefixList
 *
 * @package Black\Bundle\PersonBundle\Form\ChoiceList
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class HonorificPrefixList extends LazyChoiceList
{
    /**
     * @return mixed
     */
    public function createList()
    {
        $class  = $this->getClass();
        $page   = new $class();

        return $page;
    }

    /**
     * @return \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface|SimpleChoiceList
     */
    protected function loadChoiceList()
    {
        $array = array(
            'Mr'    => 'person.admin.person.honorificPrefix.choice.mr.text',
            'Miss'  => 'person.admin.person.honorificPrefix.choice.miss.text',
            'Mrs'   => 'person.admin.person.honorificPrefix.choice.mrs.text',
            'Pr'    => 'person.admin.person.honorificPrefix.choice.pr.text',
            'Dr'    => 'person.admin.person.honorificPrefix.choice.dr.text'
        );

        $choices = new SimpleChoiceList($array);

        return $choices;
    }

    /**
     * @return $this
     */
    protected function getClass()
    {
        return $this;
    }
}
