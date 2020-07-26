<?php

namespace App\Http\Controllers\AdvCampaigns;


use App\Http\Requests\ActivityStatisticRequest;
use App\ListSearch\SearchQuery;
use App\ListSearch\SearchQueryBuilder;
use App\Services\AdvCampaigns\ActivityStatisticService;
use App\Services\Export\Diagrams\DiagramService;
use App\Services\Export\ExportReportsToExcelService;
use Carbon\Carbon;


class ReportController extends Controller
{

    /**
     * @var ActivityStatisticService
     */
    private $activityStatisticService;

    public function __construct(ActivityStatisticService $activityStatisticService)
    {
        $this->activityStatisticService = $activityStatisticService;
    }

    public function exportToExcel(
        ActivityStatisticRequest $request,
        ExportReportsToExcelService $exportReportsToExcelService,
        DiagramService $diagramService
    )
    {
        $query = $this->getQuery($request);
        //получаем данный для отчета сторонним сервисом
        $campaignCollection = $this->activityStatisticService->getExcelExportData($query);

        // порлучаем отдедльные части для построения диаграмм отчетов
        $diagramsData = $this->activityStatisticService->getStatisticParts($query);

        $filesResponses = [];
        /** @var PartsReport $partsReport */
        foreach ($diagramsData as $partsReport) {
            $type = $partsReport->getType();
            $diagram = $diagramService->getDiagram($type, $partsReport);
            if ($diagram instanceof Collection) {
                foreach ($diagram as $item) {
                    $filesResponses[] = $item;
                }
                continue;
            }
            $filesResponses[] = $diagram;
        }

        return $exportReportsToExcelService->downloadExcel('reports.xlsx', $campaignCollection, collect($filesResponses));
    }

    /**
     * @param ActivityStatisticRequest $request
     * @return SearchQuery
     */
    private function getQuery(ActivityStatisticRequest $request): SearchQuery
    {
        $queryBuilder = (new SearchQueryBuilder())
            ->equal('dealer', $request->input('dealer'))
            ->equal('brand', $request->input('brand'));

        $dateFrom = null;
        if ($from = $request->input('from')) {
            $dateFrom = Carbon::create($from);
        }

        $dateTo = null;
        if ($to = $request->input('to')) {
            $dateTo = Carbon::create($to);
        }

        $typeStep = null;
        if ($step = $request->input('step')) {
            $typeStep = ActivityStatisticService::STEP_NAMES[$step];
        }

        $queryBuilder
            ->greaterOrEqual('from', $dateFrom)
            ->lessOrEqual('to', $dateTo)
            ->equal('step', $typeStep);

        return $queryBuilder->toQuery();
    }


}
