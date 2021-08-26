<?php
namespace app\actions\qualificationvotes;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\Qualifications;
use app\models\QualificationVotes;
use Yii;

class SaveQualificationVoteAction extends Action
{
    public $modelClass = 'app\models\QualificationVotes';

    public function run($id)
    {
        try {
            $user = Auth::instance()->getUser();
            $qualification = Qualifications::findOne($id);

            if(!($qualification instanceof Qualifications)) {
                throw new \Exception('Qualification no encontrado');
            }

            $qualificationVote = QualificationVotes::findOne([
                'qualifications_id' => $id,
                'clients_id' => $user->client->id,
            ]);
            
            if(!($qualificationVote instanceof QualificationVotes)) {
                $qualificationVote = new QualificationVotes();
                $qualificationVote->qualifications_id = $qualification->id;
                $qualificationVote->clients_id = $user->client->id;
            }
            
            $qualificationVote->load(Yii::$app->getRequest()->getBodyParams(), '');

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $qualificationVote);
            }

            if ($qualificationVote->save() === false && !$qualificationVote->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
            
            if($qualificationVote->hasErrors()) {    
                ResponseHelper::run(500);
                return [
                    'error' => true,
                    'message' => 'error on save QualificationVote',
                    'messages' => $qualificationVote->getErrors()
                ];
            }

            return $qualificationVote;
        } catch (\Throwable $th) {
            var_dump($th);die;
            ResponseHelper::run(500);
            return [ 'error' => true, 'message'  => $th->getMessage()];
        }
    }
}
