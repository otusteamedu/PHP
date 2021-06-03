<?php
declare(strict_types=1);

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Reports\BankStatementService;
use App\Http\Requests\Reports\BankStatementRequest;
use App\Http\Requests\Reports\BankStatementStatusRequest;

/**
 * @OA\Info(
 *    title="Reports API",
 *    version="1.0.0"
 * )
 *
 * Class BankStatementController
 * @package App\Http\Controllers\Reports
 */
class BankStatementController extends Controller
{
    /**
     * @var BankStatementService
     */
    protected BankStatementService $bankStatementService;

    /**
     * BankStatementController constructor.
     *
     * @param BankStatementService $bankStatementService
     */
    public function __construct(BankStatementService $bankStatementService)
    {
        $this->bankStatementService = $bankStatementService;
    }

    /**
     * @OA\Get(
     * path="/api/reports/bank-statement/generate",
     * summary="Generate report in queue",
     * description="Generate report in queue",
     * tags={"reports"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass date credentials",
     *    @OA\JsonContent(
     *       required={"from","to"},
     *       @OA\Property(property="from", type="string", format="date-time", example="2021-06-03 09:04:57"),
     *       @OA\Property(property="to", type="string", format="date-time", example="2021-06-03 09:04:57")
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="Success"),
     *       @OA\Property(property="message", type="string", example="Report generation process has been successfully added to queue!"),
     *       @OA\Property(property="job_guid", type="string", example="9395afcc-34aa-49a5-84a8-3e610d9585e0")
     *        )
     *     )
     * )
     * @OA\Response(
     *    response=400,
     *    description="Fail",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="error"),
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="error_code", type="string"),
     *       @OA\Property(property="trace", type="string")
     *        )
     *     )
     * )
     *
     * @param BankStatementRequest $request
     *
     * @return JsonResponse
     */
    public function generate(BankStatementRequest $request): JsonResponse
    {
        try {
            $jobGuid = $this->bankStatementService->generateReportAsync($request->validated());

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Report generation process has been successfully added to queue!',
                    'job_guid' => $jobGuid
                ], 201
            );

        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                    'trace' => $e->getTraceAsString()
                ], 400);
        }
    }

    /**
     * @OA\Get(
     * path="/api/reports/bank-statement/status",
     * summary="Check job status",
     * description="Check job status",
     * tags={"reports"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass date credentials",
     *    @OA\JsonContent(
     *       required={"from","to"},
     *       @OA\Property(property="guid", type="string", example="9395afcc-34aa-49a5-84a8-3e610d9585e0"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="Success"),
     *       @OA\Property(property="message", type="string", example="Report generation process has been successfully added to queue!"),
     *       @OA\Property(property="start_date", type="string")
     *       @OA\Property(property="end_date", type="string")
     *       @OA\Property(property="job_guid", type="string")
     *       @OA\Property(property="report", type="string")
     *       @OA\Property(property="created_at", type="string")
     *       @OA\Property(property="updated_at", type="string")
     *        )
     *     )
     * )
     * @OA\Response(
     *    response=400,
     *    description="Fail",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="error"),
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="error_code", type="string"),
     *       @OA\Property(property="trace", type="string")
     *        )
     *     )
     * )
     *
     * @param BankStatementStatusRequest $request
     *
     * @return JsonResponse
     */
    public function status(BankStatementStatusRequest $request): JsonResponse
    {
        try {
            if ($report = $this->bankStatementService->getReportByGuid($request->guid)) {
                $createdAt = $report->created_at ? Carbon::parse($report->created_at)->format('H:i:s, d.m.Y') : null;
                $updatedAt = $report->updated_at ? Carbon::parse($report->updated_at)->format('H:i:s, d.m.Y') : null;

                return response()->json(
                    [
                        'status' => 'success',
                        'message' => 'Report generation has been completed!',
                        'start_date' => $report->start_date,
                        'end_date' => $report->end_date,
                        'job_guid' => $report->job_guid,
                        'report' => $report->report,
                        'created_at' => $createdAt,
                        'updated_at' => $updatedAt
                    ], 200
                );
            }

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Report generation has not been finished yet!',
                    'job_guid' => $request->guid,
                ], 200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                    'trace' => $e->getTraceAsString()
                ], 400);
        }
    }
}
