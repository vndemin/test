<?php

declare(strict_types=1);

namespace App\Controller\GetReport;

use App\Exception\ServiceIsNotAvailable;
use App\UseCase\GetReportUseCase;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Controller
{

    public function __construct(
        private GetReportUseCase $useCase
    ) {
    }

    /**
     * Отчет статистики по странам
     *
     * @Rest\Get(
     *     "/api/v1/report"
     * ),
     *
     * @OA\Get(
     *     @OA\Response(
     *         response="204",
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="ru", type="integer", example=1),
     *             @OA\Property(property="uz", type="integer", example=1),
     *             @OA\Property(property="kz", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response="503",
     *         description="Error: Service Unavailable"
     *     )
     * )
     */
    public function handle(): View
    {
        try {
            $result = $this->useCase->execute();
        } catch (ServiceIsNotAvailable $exception) {
            return View::create(null, HttpResponse::HTTP_SERVICE_UNAVAILABLE);
        }

        return View::create($result, HttpResponse::HTTP_OK);
    }
}