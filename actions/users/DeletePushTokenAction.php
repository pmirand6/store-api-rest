<?php
namespace app\actions\users;

use Yii;
use yii\web\ServerErrorHttpException;
use Exception;
use app\models\Users;
use yii\rest\Action;
use app\apis\Auth;

class DeletePushTokenAction extends Action
{
    public $modelClass = 'app\models\PushTokens';
    public $getToken;

    /**
     * Deletes a model.
     * @param mixed $id id of the model to be deleted.
     * @throws ServerErrorHttpException on failure.
     */
    public function run()
    {
        
        $auth = Auth::instance();
        $user = $auth->getUser();
        
        if(!($user instanceof Users)) {
            throw new Exception("No está registrado");
        }

        $model = $this->modelClass::findOne([
            'users_id' => $user->id,
            'token' => call_user_func($this->getToken),
        ]);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        Yii::$app->getResponse()->setStatusCode(204);
    }
}
