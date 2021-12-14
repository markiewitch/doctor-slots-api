<?php
declare(strict_types=1);

namespace App\Adapters\Http;

use App\Domain\Ports\SlotRepository;
use App\ValueObject\ListSlotsRequest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SlotsController
{

    public function __construct(private SlotRepository $slots, private LoggerInterface $logger)
    {
    }

    /**
     * @Route("/slots", name="slots")
     */
    public function __invoke(ListSlotsRequest $request): Response
    {
        $this->logger->info("List lots request", ['request' => $request]);

        $data = $this->slots->queryBy(
            cursor: $request->getCursor(),
            orderBy: $request->getSortType(),
            from: $request->getDateFrom(),
            to: $request->getDateTo(),
            limit: $request->getLimit(),
        );
        return new JsonResponse([
            'next_cursor' => $data->nextCursor,
            'slots' => array_map([SlotRepresentation::class, 'of'], $data->items),
        ]);
    }
}
