<?php
declare(strict_types=1);

namespace App\Controllers\Reports;

use Exception;
use Twig\Environment;
use Twig\Error\SyntaxError;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use App\Services\ReportService;
use App\DTOs\BankStatementInputDTO;
use App\Exceptions\FailToFetchCurrentRequest;
use Symfony\Component\HttpFoundation\Response;

class BankStatementController
{
    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var ReportService
     */
    private ReportService $reportService;

    /**
     * BankStatementController constructor.
     *
     * @param Environment $twig
     * @param ReportService $reportService
     */
    public function __construct(Environment $twig, ReportService $reportService)
    {
        $this->twig = $twig;
        $this->reportService = $reportService;
    }

    /**
     * @return Response
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(): Response
    {
        return new Response(
            $this->twig->render('reports/bank-statement.html.twig')
        );
    }

    /**
     * @param BankStatementInputDTO $dates
     *
     * @return Response
     *
     * @throws FailToFetchCurrentRequest
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function generate(BankStatementInputDTO $dates): Response
    {
        $dates->validate();
        $this->reportService->createBankStatementReportAsync($dates);

        //dispatch this data to queue, to make real reporting, just simulate it ;)

        return new Response(
            $this->twig->render('reports/pushed-to-the-queue.html.twig')
        );
    }
}
