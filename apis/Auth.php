<?php
// src/Main.php

namespace app\apis;

use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\TokenVerifier;
use Kodus\Cache\FileCache;
use Yii;
use app\models\Users;
use app\models\Auth0;

class Auth {

    protected $issuer;
    protected $audience;
    protected $token;
    protected $tokenInfo;

    public function __construct() {
        $this->issuer = 'https://feriame.us.auth0.com/';
        $this->audience = 'https://tienda.feriame.com';
    }

    public function setCurrentToken($token) {
        $cacheHandler = new FileCache('./cache', 600);
        $jwksUri      = $this->issuer . '.well-known/jwks.json';

        $jwksFetcher   = new JWKFetcher($cacheHandler, [ 'base_uri' => $jwksUri ]);
        $sigVerifier   = new AsymmetricVerifier($jwksFetcher);
        $tokenVerifier = new TokenVerifier($this->issuer, $this->audience, $sigVerifier);

        try {
            $this->tokenInfo = $tokenVerifier->verify($token);
            $this->token = $token;
        }
        catch(InvalidTokenException $e) {
            // Handle invalid JWT exception ...
            $this->token = null;
            Yii::error($e->getMessage());
        }
    }

    public function checkPermission($permission)
    {
        if($this->tokenInfo) {
            return \in_array($permission, $this->tokenInfo['permissions']);
        } 
        
        return false;
    }

    public function getTokenInfo()
    {
        return $this->tokenInfo;
    }

    public function getUserInfo()
    {
        $authorization = "Authorization: Bearer $this->token";
        $ch = curl_init($this->issuer . "userinfo");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json' , $authorization
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
            
        return $result ? json_decode($result) : null;
    }

    public function getUser($low = false)
    {
        if(!$this->tokenInfo) {
            if($low) {
                return null;
            } else {
                throw new \Exception("ERROR_TOKEN");
            }
        }

        $sub = $this->tokenInfo['sub'];
        $auth0 = Auth0::find()
            ->joinWith(['user', 'user.client', 'user.provider', 'user.admin'])
            ->where(['sub' => $sub])
            ->one();

        if(!$auth0) {
            $userInfo = $this->getUserInfo();

            if(!$userInfo) {
                if($low) {
                    return null;
                } else {
                    throw new \Exception("ERROR_TOKEN");
                }
            }

            $user = isset($userInfo->email) ? Users::find()->where(['email' => $userInfo->email])->one() : null;

            if(!$user) {
                return null;
            }

            $auth0 = new Auth0();
            $auth0->sub = $sub;
            $auth0->users_id = $user->id;
            if(!$auth0->save()) {
                throw new \Exception("Error al crear el registro de auth0");
            }
        }

        return $auth0->user;
    }
    public static function instance()
    {
        $auth = new Auth();
        $request = Yii::$app->request;
        $headers = $request->getHeaders();
        if($headers['authorization']) {
            $token = trim( str_replace('Bearer', '', $headers['authorization']) );
            $auth->setCurrentToken($token);
        }

        return $auth;
    }

    public function getToken()
    {
        return $this->token;
    }
}