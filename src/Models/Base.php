<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Models;

use ArrayAccess;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use JsonSerializable;

class Base implements ArrayAccess, JsonSerializable {
    use HasAttributes;// getAttribute

    protected $fields;
    protected $id;
    protected $included;

    // protected $relationships;
    protected $api;
    protected $incrementing = true;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $perPage = 50;
    protected $relationships;

    public function __construct(array $params = [], $api = null) {
        if (isset($api->included)) {
            $this->included = $api->included;
        }
        $this->id = $params['id'];

        $this->attributes = $params;
        $this->original = $params;

        if (isset($params['relationships'])) {
            $this->relationships = $this->relation($params['relationships']);
        }
        $this->api = $api;
    }

    public function __get($key) {
        return $this->getAttribute($key);
    }

    /**
     * Model名::all()、find()等を呼ばれた場合の想定.
     */
    public static function __callStatic($method, $parameters) {
        return (new static())->{$method}(...$parameters);
    }

    /**
     * $model->items()などリレーションへのアクセスの想定メソッド.
     */
    public function __call($name, $args) {
        if (isset($this->relationFields) && !in_array($name, $this->relationFields, true)) {
            throw new Exception('no such relation');
        }

        return $this->getRelation($name);
    }

    /**
     * relation 設定.
     */
    private function relation($array) {
        $collect = [];
        foreach ($array as $key => $value) {
            $ret = [];
            foreach ($value['data'] as $item) {
                if (isset($this->included[$item['id']])) {
                    $ret[] = new self($this->included[$item['id']]);
                }
            }
            $collect[$key] = (object)$ret;
        }
        return (object)$collect;
    }

    public function getRelation($relation) {
        return collect($this->relationships->{$relation});
    }

    // public function update(array $attributes = [], array $options = []){
    //     $this->attributes = $this->api->update($this->id, $attributes);

    //     return $this;
    // }

    public function update(array $attributes = []) {
        $this->attributes = $this->api->update($this->id, $attributes);

        return $this;
    }

    public function jsonSerialize(): mixed {
        return $this->toArray();
    }

    public function toJson($options = 0) {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function toArray() {
        return array_merge($this->attributesToArray(), $this->relationsToArray());
    }

    public function offsetGet($offset): mixed {
        return $this->getAttribute($offset);
    }

    public function offsetSet($offset, $value): void {
        $this->setAttribute($offset, $value);
        // if (is_null($offset)) {
        //     $this->attributes[] = $value;
        // } else {
        //     $this->attributes[$offset] = $value;
        // }
    }

    public function offsetExists($offset): bool {
        return isset($this->attributes[$offset]);
    }

    public function offsetUnset($offset): void {
        unset($this->attributes[$offset]);
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing() {
        return $this->incrementing;
    }

    public function getKeyName() {
        return $this->primaryKey;
    }

    public function getKeyType() {
        return $this->keyType;
    }

    // return false
    public function usesTimestamps() {
        return false;
    }

    public static function api() {
        return (new static())->newApi();
    }

    public function newApi() {
    }

    public function attributesToArray() {
        return $this->attributes;
    }

    public function relationsToArray() {
        return [];
    }
}
