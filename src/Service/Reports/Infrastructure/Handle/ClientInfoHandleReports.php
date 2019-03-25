<?php

namespace App\Service\Reports\Infrastructure\Handle;

use App\Repository\DepositRepository;
use App\Service\Reports\Domain\Handle\HandleReportsInterface;

class ClientInfoHandleReports implements HandleReportsInterface
{
    /** @var DepositRepository */
    private $depositRepository;

    const ONE_GROUP = 'one_group';
    const TWO_GROUP = 'two_group';
    const THREE_GROUP = 'three_group';

    public function __construct(
        DepositRepository $depositRepository
    ) {
        $this->depositRepository = $depositRepository;
    }

    public function create(): array
    {
        $clientsDepositInfo = $this->depositRepository->findAverageDepositByYearBirth();
        $list = [];

        foreach ($clientsDepositInfo as $info) {
            if ((int)$info['age'] >= 18 && (int)$info['age'] < 25) {
                $this->sumDepositByGroup(self::ONE_GROUP, $info, $list);
            } elseif ((int)$info['age'] >= 25 && (int)$info['age'] < 50) {
                $this->sumDepositByGroup(self::TWO_GROUP, $info, $list);
            } else {
                $this->sumDepositByGroup(self::THREE_GROUP, $info, $list);
            }
        }

        $result = [];

        foreach ($list as $group => $element) {
            $result[$group] = $element['sum'] / $element['count'];
        }

        return $result;
    }

    /**
     * @param string $group
     * @param array $info
     * @param array $list
     */
    public function sumDepositByGroup(string $group, array $info, array &$list)
    {
        $list[$group]['sum'] = (int)(!isset($list[$group]['sum'])) ? $info['sum'] : $list[$group]['sum'] + $info['sum'];
        $list[$group]['count'] = (int)(!isset($list[$group]['count'])) ? $info['count'] : $list[$group]['count'] + $info['count'];
    }
}