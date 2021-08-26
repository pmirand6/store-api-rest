<?php
namespace app\actions\questions;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\Questions;
use Yii;

class AnswerQuestionAction extends Action
{
    public $modelClass = 'app\models\Questions';

    public function run($id)
    {
        try {
            $question = Questions::findOne($id);

            if(!($question instanceof Questions)) {
                throw new \Exception('Pregunta no encontrada');
            }

            $bodyParams = Yii::$app->getRequest()->getBodyParams();

            $question->load([ 'answer' => $bodyParams['answer'], 'answered_at' => date('Y-m-d H:i:s') ], '');

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $question);
            }

            if ($question->save() === false && !$question->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
            
            if($question->hasErrors()) {    
                ResponseHelper::run(500);
                return ['error' => true, 'message' => $question->getErrors()];
            }

            return $question;
        } catch (\Throwable $th) {
            ResponseHelper::run(500);
            return [ 'error' => true, 'message'  => $th->getMessage()];
        }
    }
}
