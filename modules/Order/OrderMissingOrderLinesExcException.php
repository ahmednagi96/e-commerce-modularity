<?php 

namespace Modules\Order;
use Symfony\Component\HttpFoundation\Response;

class OrderMissingOrderLinesExcException extends \Exception
{
    /**
     * هتعرف ميثود ستاتيك عشان الكود يبقى مقروء أكتر
     */
    public static function forOrder(): self
    {
        return new self(
            "Cannot process an order without order lines.", 
                Response::HTTP_UNPROCESSABLE_ENTITY // كود 422 (الأنسب هنا)
        );
    }
}