<?php

namespace Grkztd\MfCloud\Api;

use Grkztd\MfCloud\Client;
use Grkztd\MfCloud\Models\Base as Model;
use Illuminate\Support\Collection;

class Base{
    protected $client;
    public $included;
    public $options = [
        'per_page' => 50,
    ];

    /*
     * Return new api instance.
     */
    public function __construct(Client $client){
        $this->client = $client;
    }

    /*
     * Get one of the models from the repository.
     *
     * TODO: add limitation to api request.
     */
    public function first(){
        return $this->all()->first();
    }

    /*
     * Find a model by its primary key.
     */
    public function find(string $id, array $params = []){
        $res = $this->client->get($this->path.'/'.$id, $params);
        if(isset($res['included'])){
            $this->included = collect($res['included'])->mapWithKeys(function($item){
                return [$item['id'] => $item];
            });
        }
        return new $this->model($res['data'], $this);
    }

    /*
     * Get all of the models from the repository.
     */
    public function all($params = []){
        if($params === []){
            $options = array_merge($this->options, $params);
        }
        $res = $this->client->get($this->path, $options);
        if(isset($res['included'])){
            $this->included = collect($res['included'])->mapWithKeys(function($item){
                return [$item['id'] => $item];
            });
        }
        $collect = collect($res['data'])->map(function ($attributes) {
            return new $this->model($attributes, $this);
        });
        return $collect;
    }

    /*
     * Save a new model and return the instance.
     */
    public function create(array $params = []){
        $response = $this->client->post($this->path, $this->buildBody($params));
        return new $this->model($response, $this);
    }

    /*
     * Update a record in the repository.
     */
    public function update(string $id, array $params = []){
        $response = $this->client->put(
            $this->path.'/'.$id,
            $this->buildBody($params)
        );

        return new $this->model($response, $this);
    }

    public function firstOrCreate(array $params){
        $query = $this->all();
        foreach ($params as $key => $value) {
            $query = $query->where($key, $value);
        }
        $first = $query->first();

        if (is_null($first)) {
            return $this->create($params);
        }

        return $first;
    }

    /*
     * Delete a record in the repository.
     */
    public function delete(string $id) : bool{
        $this->client->delete($this->path.'/'.$id);

        return true;
    }

    /*
     * Build request body.
     */
    protected function buildBody(array $params) : array{
        return [
            'body' => json_encode([
                $this->baseName => $params
            ])
        ];
    }

}
