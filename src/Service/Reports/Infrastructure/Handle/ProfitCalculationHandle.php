<?php

namespace App\Service\Reports\Infrastructure\Handle;

use App\Repository\DepositFlowRepository;
use App\Service\DepositFlow\Type;
use App\Service\Reports\Domain\Handle\HandleReportsInterface;

class ProfitCalculationHandle implements HandleReportsInterface
{
    /** @var DepositFlowRepository */
    private $depositFlowRepository;

    public function __construct(
        DepositFlowRepository $depositFlowRepository
    ) {
        $this->depositFlowRepository = $depositFlowRepository;
    }

    public function create(): array
    {
        $accruals = $this->depositFlowRepository->findDepositFlowByTypeForMonth(Type::DEPOSIT_ACCRUALS);
        $commission = $this->depositFlowRepository->findDepositFlowByTypeForMonth(Type::DEPOSIT_COMMISSION);

        $result = [];
        foreach ($accruals as $date => $element) {
            $nextMonth = (new \DateTime($date . "-01"))->modify('+1 month')->format('Y-m');

            if (!isset($commission[$nextMonth])) {
                $commissionSum = 0;
            } else {
                $commissionSum = $commission[$nextMonth]['sum'];
            }

            $diff = $element['sum'] - $commissionSum;
            if ($diff < 0) {
                $result[$date] = [
                    'sum' => abs($diff),
                    'status' => "profit"
                ];
            } else {
                $result[$date] = [
                    'sum' => abs($diff),
                    'status' => "lesion"
                ];
            }
        }
        return $result;
    }
}