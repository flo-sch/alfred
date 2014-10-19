<?php

namespace Fsb\Alfred\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * HighwayRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HighwayRepository extends EntityRepository
{
    public function findAll()
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('h')
            ->from('FsbAlfredCoreBundle:Highway', 'h')
            ->where($qb->expr()->eq('h.isHidden', ':isHidden'))
            ->setParameter('isHidden', false)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getTotalPrice()
    {
        $price = 0;

        $qb = $this->_em->createQueryBuilder();

        $qb->select('SUM(h.price) price')
            ->from('FsbAlfredCoreBundle:Highway', 'h')
            ->where($qb->expr()->eq('h.isHidden', ':isHidden'))
            ->setParameter('isHidden', false)
        ;

        try {
            $result = $qb->getQuery()->getSingleResult();
            $price = (float) $result['price'];
        }
        catch (NoResultException $e) {}

        return $price;
    }
}
