<?php
declare(strict_types=1);

namespace App\Kernel\Api\Controller;

use App\Kernel\Api\Response\ApiResponse;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use NinjaBuggs\ServiceBus\Command\CommandBusInterface;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    protected $commandBus;
    protected $queryBus;
    protected $serializer;
    protected $context;

    public function __construct(
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        SerializerInterface $serializer
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->serializer = $serializer;
        $this->context = new SerializationContext();
    }

    /**
     * @param mixed $data
     */
    protected function buildSerializedResponse($data = [], array $groups = []): Response
    {
        if ($groups) {
            $this->context->setGroups($groups);
        }

        return ApiResponse::details(
            json_decode($this->serializer->serialize($data, 'json', $this->context), true)
        )->toHttpResponse();
    }

    /**
     * @param mixed $data
     */
    protected function buildSerializedListResponse($data, int $total, array $groups = []): Response
    {
        if ($groups) {
            $this->context->setGroups($groups);
        }

        return ApiResponse::list(
            json_decode($this->serializer->serialize($data, 'json', $this->context), true),
            $total
        )->toHttpResponse();
    }

    protected function buildFailResponse(string $error = ApiResponse::ERROR_SERVER_FAILED, ?int $code = null): Response
    {
        return ApiResponse::fail($error, $code)->toHttpResponse();
    }

    protected function buildSuccessResponse(): Response
    {
        return ApiResponse::success()->toHttpResponse();
    }

    protected function decodeRequestContent(Request $request): array
    {
        return json_decode($request->getContent(), true);
    }
}