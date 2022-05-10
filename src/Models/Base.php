<?php

namespace Grkztd\MfCloud\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use ArrayAccess;
use JsonSerializable;

class Base implements ArrayAccess, JsonSerializable{
    use HasAttributes;//getAttribute

    protected $fields;
    protected $incrementing = true;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $perPage = 50;

    public function __construct(array $params, $api = null){
        if(isset($api->included)){
            $this->included = $api->included;
        }
        $this->id = $params['id'];

        $this->attributes = $params['attributes'];
        $this->original = $params['attributes'];

        if(isset($params['relationships'])){
            $this->relationships = $this->relation($params['relationships']);
        }
        $this->api = $api;
    }

    public function __get($key){
        return $this->getAttribute($key);
    }

    /**
     * Model名::all()、find()等を呼ばれた場合の想定
     */
    public static function __callStatic($method, $parameters){
        return (new static)->$method(...$parameters);
    }

    /**
     * $model->items()などリレーションへのアクセスの想定メソッド
     */
    public function __call($name, $args){
        if (!in_array($name, $this->relationFields)){
            throw new \Exception('no such relation');
        }

        return $this->getRelation($name);
    }

    /**
     * relation 設定
     */
    private function relation($array){
        $collect = [];
        foreach($array as $key => $value){
            $ret = [];
            foreach($value['data'] as $item){
                if(isset($this->included[$item['id']])){
                    $ret[] = new self($this->included[$item['id']]);
                }
            }
            $collect[$key] = (object)$ret;
        }
        return (object)$collect;
    }

    public function getRelation($relation){
        return collect($this->relationships->$relation);
    }

    public function update(array $attributes = [], array $options = []){
        $this->attributes = $this->api->update($this->id, $attributes);

        return $this;
    }

    public function jsonSerialize(){
        return $this->toArray();
    }

    public function toJson($options = 0){
        return json_encode($this->jsonSerialize(), $options);
    }

    public function toArray(){
        return array_merge($this->attributesToArray(), $this->relationsToArray());
    }

    public function offsetGet($offset) {
        return $this->getAttribute($offset);
    }

    public function offsetSet($offset, $value) {
        $this->setAttribute($offset, $value);
        // if (is_null($offset)) {
        //     $this->attributes[] = $value;
        // } else {
        //     $this->attributes[$offset] = $value;
        // }
    }

    public function offsetExists($offset) {
        return isset($this->attributes[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->attributes[$offset]);
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(){
        return $this->incrementing;
    }

    public function getKeyName(){
        return $this->primaryKey;
    }

    public function getKeyType(){
        return $this->keyType;
    }

    // return false
    public function usesTimestamps(){
        return false;
    }

    public static function api(){
        return (new static)->newApi();
    }

    public function newApi(){

    }
}
