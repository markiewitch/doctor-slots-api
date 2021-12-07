<?php
declare(strict_types=1);

namespace App\Adapters\Http;

use App\Domain\Ports\SlotRepository;
use App\ValueObject\ListSlotsRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SlotsController
{

    public function __construct(private SlotRepository $slots)
    {
    }

    /**
     * @Route("/slots", name="slots")
     */
    public function __invoke(ListSlotsRequest $request): Response
    {
        return new JsonResponse(
            $this->slots->queryBy(
                orderBy: $request->getSortType(),
                from: $request->getDateFrom(),
                to: $request->getDateTo()));
    }
}
