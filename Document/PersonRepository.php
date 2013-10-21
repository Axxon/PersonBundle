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

use Black\Bundle\PersonBundle\Model\PersonRepositoryInterface;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentNotFoundException;

/**
 * Class PersonRepository
 *
 * @package Black\Bundle\PersonBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PersonRepository extends DocumentRepository implements PersonRepositoryInterface
{
    /**
     * @param int $limit
     *
     * @return \Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|\MongoCursor
     */
    public function getLastPersons($limit = 3)
    {
        $qb = $this->getQueryBuilder()
                ->sort('createdAt', 'desc')
                ->limit($limit)
                ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $slug
     *
     * @return object
     * @throws UsernameNotFoundException
     */
    public function getPersonBySlug($slug)
    {
        $qb = $this->createQueryBuilder()
                ->field('slug')->equals($slug)
                ->getQuery();
        try {
            $person = $qb->getSingleResult();

        } catch (DocumentNotFoundException $e) {
            throw new UsernameNotFoundException(
                sprintf('Unable to find an active person object identified by "%s".', $slug)
            );
        }

        return $person;
    }

    /**
     * @param $id
     *
     * @return object
     * @throws UsernameNotFoundException
     */
    public function getPersonById($id)
    {
        $qb = $this->createQueryBuilder()
            ->field('id')->equals($id)
            ->getQuery();
        try {
            $person = $qb->getSingleResult();

        } catch (DocumentNotFoundException $e) {
            throw new UsernameNotFoundException(
                sprintf('Unable to find an active person object identified by "%s".', $id)
            );
        }

        return $person;
    }

    /**
     * @param array $ids
     *
     * @return \Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|\MongoCursor
     */
    public function getPersonsByIds(array $ids = array())
    {
        $qb = $this
            ->createQueryBuilder()
            ->field('id')->in($ids)
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param array $ids
     *
     * @return \Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|\MongoCursor|mixed
     */
    public function getPersonsByCountries(array $ids = array())
    {
        $qb = $this
            ->createQueryBuilder()
            ->field('id')->in($ids)
            ->map(
                'function() {
                    if(this.address) {
                        key = { country: this.address[0].addressCountry };
                        value = { count: 1 };
                        emit(key, value);
                    }
                }'
            )
            ->reduce(
                'function(key, values) {
                    var count = 0;

                    values.forEach(function(v) {
                      count += v.count;
                    });

                    return {count: count, country: key.country};
                }'
            )
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $person
     *
     * @return \Doctrine\MongoDB\Query\Builder
     */
    public function getAllExcept($person)
    {
        $qb = $this
            ->createQueryBuilder()
            ->field('id')->notIn($person);

        return $qb;
    }

    /**
     * @return \Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|\MongoCursor
     */
    public function getAll()
    {
        $qb = $this
            ->createQueryBuilder()
            ->sort('name', 'ASC')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $text
     *
     * @return \Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|\MongoCursor
     */
    public function searchPerson($text)
    {
        $text = new \MongoRegex('/' . $text . '/\i');

        $qb = $this->getQueryBuilder();
        $qb = $qb
                ->addOr($qb->expr()->field('name')->equals($text))
                ->addOr($qb->expr()->field('email')->equals($text))
                ->addOr($qb->expr()->field('address.addressCountry')->equals($text))
                ->getQuery();

        return $qb->execute();
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder();
    }
}
