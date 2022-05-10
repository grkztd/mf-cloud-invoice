<?php

namespace Grkztd\MfCloud\Providers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\AccessToken;

class MoneyForwardProvider extends AbstractProvider implements ProviderInterface{
    protected $serviceName = 'mf-invoice';
    protected $scopes = ['write'];
    protected $authorizeUrl = 'https://invoice.moneyforward.com/oauth/authorize';
    protected $tokenUrl = 'https://invoice.moneyforward.com/oauth/token';
    protected $env;
    
    /**
     * {@inheritdoc}
     */
    public function __construct(Request $request, $clientId, $clientSecret, $redirectUrl, $guzzle = []){
        parent::__construct($request, $clientId, $clientSecret, $redirectUrl, $guzzle);
        $this->env = config('app.env');
    }

    /**
     * 実際のトークン取得メソッド
     */
    public function useToken(){
        $token = AccessToken::where('service_name', $this->serviceName)->where('user', $this->env)->orderBy('created_at', 'DESC')->get();
        if($token->isEmpty()){
            $response = $this->getAccessTokenResponse($this->getCode());
            AccessToken::create([
                "user" => $this->env,
                "service_name" => $this->serviceName,
                "access_token" => $response['access_token'],
                "token_type" => $response['token_type'],
                "expires_in" => $response['expires_in'],
                "refresh_token" => $response['refresh_token'],
                "scope" => $response['scope'],
                "created_at" => $response['created_at'],
            ]);
        }else
        if(!$token->first()->living()){
            $response = $this->getAccessTokenResponseByRefreshToken($token->first()->refresh_token);
            AccessToken::create([
                "user" => $this->env,
                "service_name" => $this->serviceName,
                "access_token" => $response['access_token'],
                "token_type" => $response['token_type'],
                "expires_in" => $response['expires_in'],
                "refresh_token" => $response['refresh_token'],
                "scope" => $response['scope'],
                "created_at" => $response['created_at'],
            ]);
        }else{
            $response = $token->first()->toArray();
        }
        return $response['access_token'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state){
        return $this->buildAuthUrlFromBase($this->authorizeUrl, $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl(){
        return $this->tokenUrl;
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token){
        $userUrl = $this->tokenUrl;

        $response = $this->getHttpClient()->get(
            $userUrl, $this->getRequestOptions($token)
        );

        $user = json_decode($response->getBody(), true);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCode(){
        return $this->request->input('code');
    }

    /**
     * {@inheritdoc}
     */
    protected function getCodeFields($state = null){
        return [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'response_type' => 'code',
            'scope' => $this->formatScopes($this->getScopes(), $this->scopeSeparator),
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code){
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUrl,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessTokenResponse($code){
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' => ['Accept' => 'application/json'],
            'form_params' => $this->getTokenFields($code),
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Get the POST parameters for the refresh request.
     * @return Array
     */
    protected function getRefreshTokenFields($refreshToken){
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];
    }
    
    /**
     * Get the access token response for the given code.
     *
     * @param  string  $refresh_token
     * @return array
     */
    public function getAccessTokenResponseByRefreshToken($refresh_token){
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' => ['Accept' => 'application/json'],
            'form_params' => $this->getRefreshTokenFields($refresh_token),
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function redirect(){
        $state = null;

        if ($this->usesState()) {
            $this->request->session()->put('state', $state = $this->getState());
        }

        return new RedirectResponse($this->getAuthUrl($state));
    }
}