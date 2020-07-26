<?php

namespace App\Services\Export;

use App\ExportReports;
use App\ExportReportsRowBuilder;
use App\Services\Export\Diagrams\DiagramResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet_Drawing;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportReportsToExcelServiceImpl implements ExportReportsToExcelService
{

    public function downloadExcel(string $filename, Collection $campaignCollection, Collection $filesResponses)
    {
        $exportRows = $this->getRows($campaignCollection);
        $exportRowsTitle = $this->getRowsTitle($campaignCollection);

        if (empty($exportRows)) {
            $exportRows[] = array_fill(0, count($exportRowsTitle), '');
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $excelFilePath = (new FastExcel(collect($exportRows)))->export($filename, static function ($row) use ($exportRowsTitle) {
            return array_combine($exportRowsTitle, $row);
        });

        /** @noinspection PhpUnhandledExceptionInspection */
        $objPHPExcel = PHPExcel_IOFactory::load($excelFilePath);

        $this->insertDiagramsToExcel($filesResponses, $objPHPExcel);
        $streamDownloadResponse = $this->download($objPHPExcel, $filename);
        $this->removeDiagramsFiles($filesResponses);

        return $streamDownloadResponse;
    }

    private function insertDiagramsToExcel(Collection $filesResponses, \PHPExcel $objPHPExcel)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $currentSheet = $objPHPExcel->getActiveSheet();
        $currentSheet->setTitle('Активности');
        /** @noinspection PhpUnhandledExceptionInspection */
        $sheet = $objPHPExcel->createSheet();
        $sheet->setTitle('Диаграммы');

        $filesResponses->map(static function (DiagramResponse $diagramResponse, $key) use ($sheet) {
            $sheet->getRowDimension($key + 1)->setRowHeight($diagramResponse->height);
            $objDrawing = new PHPExcel_Worksheet_Drawing;
            $objDrawing->setPath($diagramResponse->filePath);
            $objDrawing->setCoordinates(sprintf('A%s', $key + 1));
            $objDrawing->setOffsetX(5);
            $objDrawing->setOffsetY(5);
            $objDrawing->setWidth($diagramResponse->width);
            $objDrawing->setHeight($diagramResponse->height);
            $objDrawing->setWorksheet($sheet);
        });

        $sheet->getColumnDimension('A')->setAutoSize(true);
    }

    private function download(\PHPExcel $objPHPExcel, string $filename)
    {
        $excelFilePath = $this->getPath($filename);
        /** @noinspection PhpUnhandledExceptionInspection */
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        /** @noinspection PhpUnhandledExceptionInspection */
        $objWriter->save($excelFilePath);
        $excelOutput = file_get_contents($excelFilePath);
        unlink($excelFilePath);

        return response()->streamDownload(static function () use ($excelOutput) {
            echo $excelOutput;
        }, $filename);
    }

    private function removeDiagramsFiles(Collection $filesResponses)
    {
        $filesResponses->each(static function (DiagramResponse $diagramResponse) {
            unlink($diagramResponse->filePath);
        });
    }

    public function getPath($title) {
        /** @noinspection PhpUndefinedMethodInspection */
        $publicPath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        return $publicPath . $title;
    }

    /**
     * @param Collection $campaignCollection
     * @return array
     */
    private function getRows(Collection $campaignCollection): array
    {
        $exportRows = [];
        foreach ($campaignCollection as $activity) {
            $exportRows[] = (new ExportReportsRowBuilder())
                ->setCampaignCode($activity->campaign_code)
                ->setCampaignName($activity->campaign_name)
                ->setCampaignDateCreate($activity->campaign_created_at)
                ->setCampaignCost($activity->campaign_cost)
                ->setCampaignStep($activity->campaign_step)
                ->setDealerCode($activity->company_code)
                ->setDealerName($activity->company_name)
                ->setBrandName($activity->brand_name)
                ->setActivitiesCount($activity->activities_count)
                ->setActivityCity($activity->city_name)
                ->setActivityCountry($activity->country_name)
                ->setActivityType($activity->activity_type_name)
                ->setActivityCost($activity->activity_cost)
                ->setActivityStartDate($activity->activity_start_date)
                ->setActivityFinishDate($activity->activity_finish_date)
                ->setStageApprovedByManager($activity->stage_wait_to_approving)
                ->setStageApprovedByMarketer($activity->stage_wait_to_approving)
                ->toArray();
        }
        return $exportRows;
    }

    /**
     * @param Collection $requests
     * @return array
     */
    private function getRowsTitle(Collection $requests): array
    {
        $rowsTitle = [
            ExportReports::ADVERTISING_CAMPAIGN_CODE_TITLE,
            ExportReports::ADVERTISING_CAMPAIGN_NAME_TITLE,
            ExportReports::ADVERTISING_CAMPAIGN_DATE_CREATE_TITLE,
            ExportReports::ADVERTISING_CAMPAIGN_COST_TITLE,
            ExportReports::DEALER_CODE_TITLE,
            ExportReports::DEALER_NAME_TITLE,
            ExportReports::BRAND_NAME_TITLE,
            ExportReports::ACTIVITIES_COUNT_TITLE,
            ExportReports::ACTIVITY_CITY_TITLE,
            ExportReports::ACTIVITY_COUNTRY_TITLE,
            ExportReports::ACTIVITY_TYPE_NAME_TITLE,
            ExportReports::ACTIVITY_COST_TITLE,
            ExportReports::ACTIVITY_DATE_START_TITLE,
            ExportReports::ACTIVITY_DATE_END_TITLE,
            ExportReports::CAMPAIGN_STEP_TITLE,
            ExportReports::MODERATOR_APPROVED_TITLE,
            ExportReports::MARKETER_APPROVED_TITLE,

        ];

        return $rowsTitle;
    }
}
