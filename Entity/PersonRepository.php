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

use Black\Bundle\PersonBundle\Model\PersonRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Class PersonRepository
 *
 * @package Black\Bundle\PersonBundle\Entity
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PersonRepository extends EntityRepository implements PersonRepositoryInterface
{
    /**
     * @param integer $limit
     *
     * @return mixed
     */
    public function getLastPersons($limit = 3)
    {
        $qb = $this->getQueryBuilder()
                ->orderBy('p.createdAt', 'DESC')
                ->setMaxResults($limit)
                ->getQuery();

        return $qb->getResult();
    }

    /**
     * @param string $slug
     *
     * @return object
     * @throws UsernameNotFoundException
     */
    public function getPersonBySlug($slug)
    {
        $qb = $this->createQueryBuilder()
                ->where('p.slug LIKE :slug')
                ->setParameter('slug', $slug)
                ->getQuery();
        try {
            $person = $qb->getSingleResult();

        } catch (EntityNotFoundException $e) {
            throw new UsernameNotFoundException(
                sprintf('Unable to find an active person object identified by "%s".', $slug)
            );
        }

        return $person;
    }

    /**
     * @param integer $id
     *
     * @return object
     * @throws UsernameNotFoundException
     */
    public function getPersonById($id)
    {
        $qb = $this->createQueryBuilder()
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery();
        try {
            $person = $qb->getSingleResult();

        } catch (EntityNotFoundException $e) {
            throw new UsernameNotFoundException(
                sprintf('Unable to find an active person object identified by "%s".', $id)
            );
        }

        return $person;
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function getPersonsByIds(array $ids = array())
    {
        $qb = $this->createQueryBuilder()
                ->where($qb->expr()->in('p.id', ':ids'))
                ->setParameter('ids', $ids)
                ->getQuery();

        return $qb->execute();
    }

    /**
     * @param array $ids
     *
     * @return mixed
     */
    public function getPersonsByCountries(array $ids = array())
    {
        $qb = $this->createQueryBuilder()
                ->leftJoin('p.address', 'pa')
                ->select('pa.address_country as country, COUNT(pa.address_country) as count')
                ->where(
                    $qb
                        ->expr()
                        ->in('p.id', ':ids')
                )
                ->groupBy('p.id, pa.address_country')
                ->setParameter('ids', $ids)
                ->getQuery();

        return $qb->execute();
    }

    /**
     * @param Person $person
     *
     * @return Query
     */
    public function getAllExcept($person)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.id <> :id')
                ->setParameter('id', $person);

        return $qb;
    }
    /**
     * @return mixed
     */
    public function getAll()
    {
        $qb = $this
            ->getQueryBuilder()
            ->orderBy('p.name', 'ASC')
            ->getQuery();

        return $qb->getResult();
    }

    /**
     * @param string $text
     *
     * @return mixed
     */
    public function searchPerson($text)
    {
        $qb2    = $this->getQueryBuilder('ppa');
        $qb     = $this->getQueryBuilder();
        $qb     = $qb
                ->where(
                    $qb
                        ->expr()
                        ->orX(
                            $qb
                                ->expr()
                                ->orX(
                                    $qb->expr()->like('p.name', ':text'),
                                    $qb->expr()->like('p.email', ':text')
                                ),
                            $qb
                                ->expr()
                                ->in(
                                    'p.id',
                                    $qb2
                                        ->leftJoin('ppa.address', 'pa')
                                        ->select('ppa.id')
                                        ->where(
                                            $qb2
                                                ->expr()
                                                ->orX(
                                                    $qb2->expr()->like('pa.name', ':text'),
                                                    $qb2->expr()->like('pa.addressCountry', ':text')
                                                )
                                        )
                                        ->setParameter('text', '%'.$text.'%')
                                        ->getDQL()
                                )
                        )
                )
                ->setParameter('text', '%'.$text.'%')
                ->getQuery();

        return $qb->execute();
    }

    /**
     * @param string $alias
     * 
     * @return Query
     */
    protected function getQueryBuilder($alias = 'p')
    {
        return $this->createQueryBuilder($alias);
    }
}
