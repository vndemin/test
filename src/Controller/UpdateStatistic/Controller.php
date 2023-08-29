<?php

declare(strict_types=1);

namespace App\Controller\UpdateStatistic;

use App\Controller\UpdateStatistic\Input\Request;
use App\Exception\ServiceIsNotAvailable;
use App\UseCase\UpdateStatisticUseCase;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class Controller
{

    public function __construct(
        private UpdateStatisticUseCase $useCase
    ) {
    }

    /**
     * Обновление статистики
     *
     * @Rest\Post(
     *     "/api/v1/update-statistic"
     * )
     * @OA\Post(
     *     @OA\RequestBody(
     *         @Model(type=Request::class)
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request params",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Schema(
     *                          type="object",
     *                          @OA\Property(property="property_path", type="string", example="countryCode"),
     *                          @OA\Property(property="message", type="string", example="This value should not be blank.")
     *                     )
     *                 )
     *            ),
     *        )
     *     ),
     *     @OA\Response(
     *         response="503",
     *         description="Error: Service Unavailable"
     *     )
     * )
     */
    public function handle(Request $request, ConstraintViolationListInterface $validationErrors): View
    {
        if ($validationErrors->count()) {
            return View::create(['errors' => $validationErrors], HttpResponse::HTTP_BAD_REQUEST);
        }
        try {
            $this->useCase->execute($request->countryCode);
        } catch (ServiceIsNotAvailable $exception) {
            return View::create(null, HttpResponse::HTTP_SERVICE_UNAVAILABLE);
        }

        return View::create(null, HttpResponse::HTTP_NO_CONTENT);
    }
}