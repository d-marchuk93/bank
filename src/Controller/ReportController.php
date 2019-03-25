<?php

namespace App\Controller;

use App\Service\Reports\Infrastructure\Handle\ClientInfoHandleReports;
use App\Service\Reports\Infrastructure\Handle\ProfitCalculationHandle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReportController extends AbstractController
{
    /** @var ClientInfoHandleReports */
    private $clientInfoReport;
    /** @var ProfitCalculationHandle */
    private $profitCalculationReport;

    public function __construct(
        ClientInfoHandleReports $clientInfoReport,
        ProfitCalculationHandle $profitCalculationReport
    ) {
        $this->clientInfoReport = $clientInfoReport;
        $this->profitCalculationReport = $profitCalculationReport;
    }

    public function index()
    {
        $calculation = $this->profitCalculationReport->create();
        $clientInfo = $this->clientInfoReport->create();

        return $this->render('/report.html.twig', [
            'calculation' => $calculation,
            'clientInfo' => $clientInfo
        ]);
    }
}