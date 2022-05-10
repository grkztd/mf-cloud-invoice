<?php

namespace Grkztd\MfCloud\Api;

use Grkztd\MfCloud\Api\Base;
use Grkztd\MfCloud\Models\Item as Model;

class Item extends Base{
    protected $baseName = 'item';

    protected $model = Model::class;

    protected $path = 'items';

    // protected $allowedMethods = ['all', 'get', 'create', 'update', 'delete'];
    protected $allowedMethods = ['all', 'get'];
}
