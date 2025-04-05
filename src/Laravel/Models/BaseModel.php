<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Laravel\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
    use HasFactory;
    use HasUlids;

    protected $guarded = ['id'];

    // ULID
    public $incrementing = false; // ULIDは自動増分しない
    protected $keyType = 'string'; // ULIDは文字列

    /**
     * MFデータ=>MySQLデータに合わせるためのキー変換等.
     *
     * @param array $attributes
     * @param array $options
     * @return array
     */
    protected static function fit(array $attributes, array $options) {
        $return = [];
        foreach ($attributes as $key => $val) {
            if (in_array($key, array_keys($options), true)) {
                if ($options[$key] !== null) {
                    $return[$options[$key]] = $val;
                }
            } else {
                $return[$key] = $val;
            }
        }
        return $return;
    }
}
