<?php

namespace Grkztd\MfCloud\Models;

use Grkztd\MfCloud\Models\Base;

class Item extends Base
{
    protected $fields = [
        'id', 'code', 'name', 'detail', 'unit_price', 'unit',
        'quantity', 'price', 'excise', 'created_at', 'updated_at',
    ];
}
