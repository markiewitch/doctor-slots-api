<?php

declare(strict_types=1);

namespace App\Adapters\Http;

use App\ValueObject\ListSlotsRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class HttpRequestDeserializer implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === ListSlotsRequest::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield new ListSlotsRequest(
            sortType: $request->query->get('sort_type', 'date_asc'),
            dateFrom: null,
            dateTo: null,
            limit: $request->query->getInt('limit', 15),
            cursor: $request->query->get('cursor'),
        );
    }
}
