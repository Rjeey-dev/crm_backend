<?php
declare(strict_types=1);

namespace App\Kernel\Api\Response;

use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public const ERROR_SERVER_FAILED = 'server_failed';
    public const ERROR_AUTH_FAILED = 'auth_failed';
    public const ERROR_ACCESS_DENIED = 'access_denied';
    public const ERROR_UNAUTHORIZED = 'unauthorized';
    public const ERROR_NOT_FOUND = 'not_found';
    public const ERROR_VALIDATION_FAILED = 'validation_failed';
    public const ERROR_ALREADY_EXISTS = 'already_exists';

    private const ERROR_TO_STATUS_CODE_MAP = [
        self::ERROR_SERVER_FAILED => Response::HTTP_INTERNAL_SERVER_ERROR,
        self::ERROR_AUTH_FAILED => Response::HTTP_UNAUTHORIZED,
        self::ERROR_ACCESS_DENIED => Response::HTTP_FORBIDDEN,
        self::ERROR_NOT_FOUND => Response::HTTP_NOT_FOUND,
        self::ERROR_VALIDATION_FAILED => Response::HTTP_BAD_REQUEST,
        self::ERROR_ALREADY_EXISTS => Response::HTTP_CONFLICT,
    ];

    private const STATUS_SUCCESS = 'success';
    private const STATUS_FAIL = 'fail';

    /**
     * @var string
     */
    private $status;

    /**
     * @var string|null
     */
    private $error;

    /**
     * @var array|null
     */
    private $details;

    /**
     * @var array|null
     */
    private $items;

    private $total;

    /**
     * @var int
     */
    private $code = Response::HTTP_OK;

    public static function fail(string $error = self::ERROR_SERVER_FAILED, ?int $code = null): self
    {
        $response = new self(self::STATUS_FAIL);
        $response->error = $error;

        if (!$code) {
            $code = array_key_exists($error, self::ERROR_TO_STATUS_CODE_MAP) ?
                self::ERROR_TO_STATUS_CODE_MAP[$error] :
                Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response->code = $code;

        return $response;
    }

    public static function success(): self
    {
        return new self(self::STATUS_SUCCESS);
    }

    public static function details(array $details): self
    {
        $response = self::success();
        $response->details = $details;

        return $response;
    }

    public static function list(array $items, int $total): self
    {
        $response = self::success();
        $response->items = $items;
        $response->total = $total;

        return $response;
    }

    private function __construct(string $status)
    {
        $this->status = $status;
    }

    public function toHttpResponse(): Response
    {
        return new Response(json_encode($this->getPayload()), $this->code);
    }

    private function getPayload(): array
    {
        $payload = [
            'status' => $this->status,
        ];

        if ($this->error !== null) {
            $payload['error'] = $this->error;
        }

        if ($this->details !== null) {
            $payload['details'] = $this->details;
        }

        if ($this->items !== null) {
            $payload['items'] = $this->items;
        }

        if ($this->total !== null) {
            $payload['total'] = $this->total;
        }

        return $payload;
    }
}
