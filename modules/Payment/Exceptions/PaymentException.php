<?php 

namespace Modules\Payment\Exceptions;

use Illuminate\Validation\ValidationException;

class PaymentException extends \Exception
{
    public static function invalidToken(): ValidationException
    {
        return ValidationException::withMessages([
            "payment_token" => "The given payment token is not valid."
        ]);
    }
}