<?php

namespace Grkztd\MfCloud\Api;

use Grkztd\MfCloud\Api\Base;
use Grkztd\MfCloud\Models\Billing as Model;

class Billing extends Base{
    protected $baseName = 'billing';

    protected $model = Model::class;

    protected $path = 'billings';

    // protected $allowedMethods = ['all', 'get', 'create', 'update', 'delete'];
    protected $allowedMethods = ['all', 'get'];
}
