<?php

namespace Grkztd\MfCloud\Api;

use Grkztd\MfCloud\Api\Base;
use Grkztd\MfCloud\Models\Quote as Model;

class Quote extends Base{
    protected $baseName = 'quote';

    protected $model = Model::class;

    protected $path = 'quotes';

    // protected $allowedMethods = ['all', 'get', 'create', 'update', 'delete'];
    protected $allowedMethods = ['all', 'get'];
}
