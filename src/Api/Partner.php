<?php

namespace Grkztd\MfCloud\Api;

use Grkztd\MfCloud\Api\Base;
use Grkztd\MfCloud\Models\Partner as Model;

class Partner extends Base{
    protected $baseName = 'partner';

    protected $model = Model::class;

    protected $path = 'partners';

    // protected $allowedMethods = ['all', 'get', 'create', 'update', 'delete'];
    protected $allowedMethods = ['all', 'get'];
}
