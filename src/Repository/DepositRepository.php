<?php

namespace App\Repository;

use App\Entity\Deposit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Deposit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deposit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deposit[]    findAll()
 * @method Deposit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepositRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Deposit::class);
    }

    public function findByType(int $depositId, int $typeId): ?Deposit
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.depositFlows', 'f')->addSelect('f')
            ->where('d.id = :id')
            ->setParameter('id', $depositId)
            ->andWhere('f.type_id = :type_id')
            ->setParameter('type_id', $typeId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAverageDepositByYearBirth(): array
    {
        $sql = "SELECT SUM(d.sum) `sum`, COUNT(d.sum) `count`,
                  ((YEAR(CURRENT_DATE) - YEAR(c.birthday)) -
                      (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(c.birthday, '%m%d'))
                  ) AS age
                FROM client as c LEFT JOIN deposit d ON d.client_id = c.id GROUP BY age";
        $result = $this->getEntityManager()->getConnection()->query($sql)->fetchAll();

        return $result;
    }
}
