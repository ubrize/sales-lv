<?php

namespace Ubrize\SalesLv\Exceptions;

use DomainException;
use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * Thrown when content length is greater than 800 characters.
     *
     * @return static
     */
    public static function contentLengthLimitExceeded()
    {
        return new static(
            'Notification was not sent. Content length may not be greater than 800 characters.'
        );
    }

    /**
     * Thrown when error received from sales.lv
     *
     * @param DomainException $exception
     * @return static
     */
    public static function salesLvRespondedWithAnError(DomainException $exception)
    {
        return new static(
            "Sales.lv responded with an error '{$exception->getCode()}: {$exception->getMessage()}'",
            $exception->getCode()
        );
    }

    /**
     * Thrown when we're unable to communicate with sales.lv.
     *
     * @param Exception $exception
     *
     * @return static
     */
    public static function couldNotCommunicateWithSalesLv(Exception $exception)
    {
        return new static(
            "The communication with sales.lv failed. Reason: {$exception->getMessage()}" .
            $exception->getCode(),
            $exception
        );
    }
}
