<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Exceptions;

use Exception;
use Throwable;

/**
 * Class NoAvailableStylistsException
 *
 * @package Admin\Services\StylistDesk\Stylist\Exceptions;
 */
class NoAvailableStylistsException extends Exception
{
    private const DEFAULT_ERROR_MESSAGE = 'No stylists for substitution found';

    /**
     * NoAvailableStylistsException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?: self::DEFAULT_ERROR_MESSAGE, $code, $previous);
    }
}
