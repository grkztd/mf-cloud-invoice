<?php

namespace Grkztd\MfCloud\Models;

use Grkztd\MfCloud\Models\Base;
use Grkztd\MfCloud\Models\Department;

class Partner extends Base{
    protected $fields = [
        'id', 'code', 'name', 'name_kana', 'name_suffix', 'memo', 'departments',
        'created_at', 'updated_at'
    ];
    protected $relationFields = [
        'departments',
    ];

    // public function departments(){
    //     return collect($this['departments'])->map(function ($attributes) {
    //         return new Department($attributes);
    //     });
    // }
}
