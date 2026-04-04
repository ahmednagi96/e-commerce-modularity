<?php

namespace Modules\Order\Ui\ViewComponents;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OrderLine extends Component
{
    public function __construct(public string $name)
    {
        
    }
    public function render():View
    {
        return view("order::components.order-line",[
            'age'=>40
        ]);
    }
}