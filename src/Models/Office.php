<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Models;

class Office extends Base {
    protected $fields = [
        'name', 'zip', 'prefecture', 'address1', 'address2', 'tel', 'fax',
    ];

    public function update(array $attributes = []) {
        $this->attributes = $this->api->update('', $attributes);

        return $this;
    }
}
