<?php 

namespace Modules\Payment;

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use NumberFormatter;

final class PayBuddySdk
{
    public function charge(string $token,float $amountInCents, string $statementDescription):array{
        $this->validateToken($token);

        $nomberFormatter= new NumberFormatter("en-US", NumberFormatter::CURRENCY);
        //pay 
        //          here
        //
        //is pay seccess
        return [
            'id' => (string) Str::uuid(),
            'amount_in_cents' => $amountInCents,
            'localized_amount' => $nomberFormatter->format($amountInCents / 100),
            'statement_description' => $statementDescription,
            'created_at' => now()->toDateTimeString(),
        ];
    }
        public static function make():PayBuddySdk{
            return new self();
        }

        public static function validToken(): string
        {
            return (string) Str::uuid();
        }

        public static function invalidToken(): string
        {
            return substr(self::validToken(), -35);
        }

        public function validateToken(string $token):void{
            if(! Str::isUuid($token)){
                throw  ValidationException::withMessages(
                    [
                        "payment_token"=>"The given payment token is not valid."
                    ]
                
                );
            }
        
            
    }
}

