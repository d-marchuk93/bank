<?php

namespace App\Repository;

use App\Entity\DepositFlow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DepositFlow|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepositFlow|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepositFlow[]    findAll()
 * @method DepositFlow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepositFlowRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DepositFlow::class);
    }

    /**
     * @param int $type
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findDepositFlowByTypeForMonth(int $type): array
    {
        $result = [];
        $sql = "SELECT DATE_FORMAT(date_created, '%Y-%m') `date`, SUM(sum) sum FROM deposit_flow ".
            "WHERE `type_id` = {$type} GROUP BY `date`";
        $data = $this->getEntityManager()->getConnection()->query($sql)->fetchAll();

        if (!empty($data)) {
            foreach ($data as $value) {
                $result[$value['date']] = $value;
            }
        }

        return $result;
    }
}
