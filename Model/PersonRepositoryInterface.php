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
 * Interface PersonRepositoryInterface
 *
 * @package Black\Bundle\PersonBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
interface PersonRepositoryInterface
{
    /**
     * @param $limit
     *
     * @return mixed
     */
    function getLastPersons($limit);

    /**
     * @param $slug
     *
     * @return mixed
     */
    function getPersonBySlug($slug);

    /**
     * @param $id
     *
     * @return mixed
     */
    function getPersonById($id);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    function getPersonsByIds(array $ids);

    /**
     * @param array $ids
     *
     * @return mixed
     */
    function getPersonsByCountries(array $ids);

    /**
     * @param $person
     *
     * @return mixed
     */
    function getAllExcept($person);

    /**
     * @return mixed
     */
    function getAll();

    /**
     * @param $text
     *
     * @return mixed
     */
    function searchPerson($text);
}
