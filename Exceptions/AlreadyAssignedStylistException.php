<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Exceptions;

use Exception;
use Throwable;

/**
 * Class AlreadyAssignedStylistException
 *
 * @package Admin\Services\StylistDesk\Stylist\Exceptions;
 */
class AlreadyAssignedStylistException extends Exception
{
    private const DEFAULT_ERROR_MESSAGE = 'Specified stylist is already assigned to customer';

    /**
     * AlreadyAssignedStylistException constructor.
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
