<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Api;

use Grkztd\MfCloud\Client;
use Grkztd\MfCloud\Models\Base as Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Base {
    protected $client;
    protected $path;
    protected $baseName;
    protected $model;
    public $included;
    public $options = [
        // 'query' => 'per_page=50',
        'per_page' => '50',
    ];

    /*
     * Return new api instance.
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /*
     * Get one of the models from the repository.
     *
     * TODO: add limitation to api request.
     */
    public function first() {
        return $this->all()->first();
    }

    /*
     * Find a model by its primary key.
     */
    public function find(string $id, array $params = []) {
        $res = $this->client->get($this->path . '/' . $id, $params);
        if (isset($res['included'])) {
            $this->included = collect($res['included'])->mapWithKeys(function($item) {
                return [$item['id'] => $item];
            });
        }
        return new $this->model($res['data'], $this);
    }

    /*
     * Get all of the models from the repository.
     */
    public function all($params = []) {
        $options = array_merge($this->options, $params);
        $res = $this->client->get($this->path, $options);
        if (isset($res['included'])) {
            $this->included = collect($res['included'])->mapWithKeys(function($item) {
                return [$item['id'] => $item];
            });
        }
        return collect($res['data'])->map(function($attributes) {
            return new $this->model($attributes, $this);
        });
    }

    /**
     * 追加.
     *
     * @param array $params
     */
    public function pagination($params = []) {
        $options = array_merge($this->options, $params);
        $res = $this->client->get($this->path, $options);
        if (isset($res['included'])) {
            $this->included = collect($res['included'])->mapWithKeys(function($item) {
                return [$item['id'] => $item];
            });
        }
        return new LengthAwarePaginator(
            collect($res['data'])->map(function($attributes) {
                return new $this->model($attributes, $this);
            }),
            $res['pagination']['total_count'],
            $res['pagination']['per_page'],
            $res['pagination']['current_page'],
            ['path' => request()->url()]
        );
    }

    /*
     * Get all of the models from the repository.
     */
    public function search($params = []) {
        $options = array_merge($this->options, $params);
        $res = $this->client->get($this->path . '/search', $options);
        if (isset($res['included'])) {
            $this->included = collect($res['included'])->mapWithKeys(function($item) {
                return [$item['id'] => $item];
            });
        }
        return collect($res['data'])->map(function($attributes) {
            return new $this->model($attributes, $this);
        });
    }

    /*
     * Save a new model and return the instance.
     */
    public function create(array $params = []) {
        $res = $this->client->post($this->path, $this->buildBody($params));
        if (isset($res['included'])) {
            $this->included = collect($res['included'])->mapWithKeys(function($item) {
                return [$item['id'] => $item];
            });
        }
        return new $this->model($res['data'], $this);
    }

    /*
     * Update a record in the repository.
     */
    public function update(string $id, array $params = []) {
        $response = $this->client->put(
            $this->path . '/' . $id,
            $this->buildBody($params)
        );

        return new $this->model($response, $this);
    }

    public function firstOrCreate(array $params) {
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
    public function delete(string $id): bool {
        $this->client->delete($this->path . '/' . $id);

        return true;
    }

    /*
     * Build request body.
     */
    protected function buildBody(array $params): array {
        return [
            'body' => json_encode([
                $this->baseName => $params
            ])
        ];
    }
}
