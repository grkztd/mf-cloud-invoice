<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Api;

use Grkztd\MfCloud\Models\Office as Model;

class Office extends Base {
    protected $path = 'office';
    protected $model = Model::class;
    protected $baseName = 'office';
    protected $allowedMethods = ['first', 'update'];

    public function first(): Model {
        return new Model($this->client->get($this->path), $this);
    }
}
