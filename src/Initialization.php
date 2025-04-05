<?php

declare(strict_types=1);
namespace Grkztd\MfCloud;

use Carbon\CarbonImmutable as Carbon;
use Grkztd\MfCloud\Laravel\Models\AccessToken;
use GuzzleHttp\Client;

class Initialization {
    private $scope = 'mfc/invoice/data.read';

    /**
     * Undocumented function.
     */
    public function access() {
        $tokenModel = $this->loadToken();
        if (Carbon::now()->gt($tokenModel['expires_at'])) {
            try{
                // expired
                $tokenModel = $this->getRefreshToken($tokenModel['refresh_token']);
                $token = $tokenModel['access_token'];
            }catch(Exception $e){
                throw $e;
            }
        } else {
            // non expired
            $token = $tokenModel['access_token'];
        }
        return $token;
    }

    /**
     *
     */
    public function getNewToken(string $code) {
        $response = (new Client())->request('POST', 'https://api.biz.moneyforward.com/token', [
            'auth' => [config('mf.invoice.client_id'), config('mf.invoice.client_secret')], // Basic 認証
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => config('mf.invoice.redirect_uri'),
            ],
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        // アクセストークンとリフレッシュトークンを保存
        $accessToken = $data['access_token'];
        $refreshToken = $data['refresh_token'];
        $expiresIn = $data['expires_in'];
        // アクセストークンをセッションやデータベースに保存することを検討
        return $this->saveToken($accessToken, $refreshToken, $expiresIn);
    }

    /**
     *
     */
    public function getRefreshToken(string $refreshToken) {
        // リフレッシュトークン
        $response = (new Client())->request('POST', 'https://api.biz.moneyforward.com/token', [
            'auth' => [config('mf.invoice.client_id'), config('mf.invoice.client_secret')], // Basic 認証
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ],
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        // アクセストークンとリフレッシュトークンを保存
        $accessToken = $data['access_token'];
        $refreshToken = $data['refresh_token'];
        $expiresIn = $data['expires_in'];
        // アクセストークンをセッションやデータベースに保存することを検討
        return $this->saveToken($accessToken, $refreshToken, $expiresIn);

        // return response()->json($data);
    }

    /**
     *
     */
    public function getNewTokenUrl() {
        $str = 'https://api.biz.moneyforward.com/authorize';
        $params = [
            'response_type' => 'code',
            'client_id' => config('mf.invoice.client_id'),
            'scope' => $this->scope,
            'redirect_uri' => config('mf.invoice.redirect_uri'),
        ];
        return $str . '?' . http_build_query($params);
    }

    /**
     * Undocumented function.
     *
     * @param [type] $accessToken
     * @param [type] $refreshToken
     * @param [type] $expiresIn
     */
    private function saveToken($accessToken, $refreshToken, $expiresIn) {
        return AccessToken::updateOrCreate(
            [
                'name' => 'mf.invoice.view'
            ],
            [
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'expires_at' => Carbon::now()->addSeconds($expiresIn)
            ]
        );
    }

    /**
     * Undocumented function.
     *
     * @param string $scope
     */
    private function loadToken($scope = 'view') {
        $tokenRecord = AccessToken::where('name', 'mf.invoice.' . $scope)->first();
        return [
            'access_token' => $tokenRecord->access_token,
            'refresh_token' => $tokenRecord->refresh_token,
            'expires_at' => Carbon::parse($tokenRecord->expires_at)
        ];
    }
}
