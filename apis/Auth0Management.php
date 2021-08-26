<?php
namespace app\apis;

class Auth0Management
{
    private $audience;
    private $client_secret;
    private $client_id;
    private $url;
    private $authorization;

    public function __construct(
        $audience = 'https://feriame.us.auth0.com/api/v2/',
        $client_secret = 'pwZ2Wg893OwfXYSk2KgY2wQMfb_8rjtGFo2MkqUlA8-965tkAQeQMUbOr7spWM5P',
        $client_id = 'p8wIVMiTROPhp7RRkb9CAsQCcL8CjGvM',
        $url = 'https://feriame.us.auth0.com'
    )
    {
        $this->audience = $audience;
        $this->client_secret = $client_secret;
        $this->client_id = $client_id;
        $this->url = $url;
        $this->setAuthorization();
    }

    private function setAuthorization(): void
    {
        $body = "{\"client_id\":\"$this->client_id\",\"client_secret\":\"$this->client_secret\",\"audience\":\"$this->audience\",\"grant_type\":\"client_credentials\"}";
        $authorization = $this->post('/oauth/token', $body);
        $this->authorization = "$authorization->token_type $authorization->access_token";
    }

    public function getAuthorization()
    {
        return $this->authorization;
    }

    private function getRole($role)
    {
        return $this->get("/api/v2/roles?name_filter=$role");
    }

    public function assignUserToRole($user, $role)
    {
        $auth0Role = $this->getRole($role);
        if($auth0Role) {
            $role_id = $auth0Role[0]->id;
            $body['users'] = [ $user ];
            
            return $this->post("/api/v2/roles/$role_id/users", \json_encode($body));
        } else {
            throw new \Exception("Auth0 role: $role not exists");
            
        }
    }
    private function post($endpoint, $body = null)
    {
        $headers[] = "content-type: application/json";
        if($this->authorization) {
            $headers[] = "Authorization: $this->authorization";
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        
        if ($err) {
            return null;
        } else {
            return \json_decode($response);
        }
    }

    private function get($endpoint)
    {
        $authorization = "Authorization: $this->authorization";
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "content-type: application/json",
                $authorization
                ], 
            ]
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        
        if ($err) {
            return null;
        } else {
           return \json_decode($response);
        }
    }
}