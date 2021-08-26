<?php
declare(strict_types=1);
namespace app\models\tools;

use app\models\Users;
use app\helpers\SendPushHelper;

class SendPushToUserTool
{
    private $user;
    private $fields;

    public function __construct(Users $user, string $title, string $body, array $data)
    {
        $this->user = $user;
        $this->fields = [
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => $data,
        ];
    }

    public function send()
    {
        foreach ($this->user->pushTokens as $pushToken) {
            $fields = $this->fields;
            $fields['to'] = $pushToken->token;

            $response = ( new SendPushHelper( $fields ) )->getResponse(); 
        }
    }
}