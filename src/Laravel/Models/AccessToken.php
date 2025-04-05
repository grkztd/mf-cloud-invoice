<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Laravel\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model {
    protected $table = 'oauth_tokens';
    protected static $name = 'mf.invoice';
    protected $guarded = ['id'];

    // ここで初期値を定義する
    protected $attributes = [
        'name' => 'mf.invoice.view',
    ];

    protected static function booted() {
        static::addGlobalScope('name', function(Builder $builder) {
            $builder->where('name', 'LIKE', self::$name . '%');
        });
    }
}
