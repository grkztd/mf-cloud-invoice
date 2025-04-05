<?php

declare(strict_types=1);
namespace Grkztd\MfCloud;

use Grkztd\MfCloud\Api\Billing;
use Grkztd\MfCloud\Api\Item;
use Grkztd\MfCloud\Api\Office;
use Grkztd\MfCloud\Api\Partner;
use Grkztd\MfCloud\Api\Quote;
use GuzzleHttp\Client as Guzzle;

class Client {
    public const BASE_URL = 'https://invoice.moneyforward.com/api';

    /** @var string */
    protected $accessToken;

    /** @var string */
    protected $apiVersion;

    /* public for test */
    /** @var Guzzle */
    public $guzzle;

    /**
     * Create a new Grkztd\MfCloud\Invoice client.
     */
    public function __construct(string $accessToken = '', ?Guzzle $guzzle = null, string $apiVersion = 'v3') {
        $this->setAccessToken($accessToken);

        if (is_null($guzzle)) {
            $guzzle = new Guzzle();
        }

        $this->guzzle = $guzzle;

        $this->apiVersion = $apiVersion;
    }

    public function office() {
        return (new Office($this))->first();
    }

    public function items() {
        return new Item($this);
    }

    public function quotes() {
        return new Quote($this);
    }

    public function partners() {
        return new Partner($this);
    }

    public function billings() {
        return new Billing($this);
    }

    public function get(string $path, array $params = []): array {
        return $this->request('GET', $path, $params);
    }

    public function post(string $path, array $params = []): array {
        return $this->request('POST', $path, $params);
    }

    public function put(string $path, array $params = []): array {
        return $this->request('PUT', $path, $params);
    }

    public function delete(string $path): array {
        return $this->request('DELETE', $path);
    }

    protected function request(string $method, string $path, array $params = []): array {
        $params = [
            'query' => $this->queryDecode($params)
        ];
        $body = $this->guzzle->request(
            $method,
            $this->buildUrl($path),
            array_merge($params, [
                'headers' => $this->getHeaders()
            ])
        )->getBody();

        return json_decode((string)$body, true);
    }

    protected function buildUrl($path): string {
        return implode('/', [static::BASE_URL, $this->apiVersion, $path]);
        // return implode('/', [static::BASE_URL, $path]);
    }

    public function setAccessToken(string $token) {
        $this->accessToken = $token;
        return $this;
    }

    private function getHeaders() {
        return [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json',
            // 'Accept' => '*/*',
        ];
    }

    public function getAccessToken() {
        return $this->accessToken;
    }

    public function download(string $method, string $path, string $filename) {
        $body = $this->guzzle->request(
            $method,
            $path,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Accept' => 'application/pdf',
                ],
            ]
        )->getBody();

        return response($body, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '.pdf"');
    }

    /**
     * 連想配列をクエリに.
     *
     * @param array $params
     */
    private function queryDecode($params = []) {
        $options = [];
        foreach ($params as $key => $val) {
            $options[] = $key . '=' . $val;
        }
        return implode('&', $options);
    }
}
