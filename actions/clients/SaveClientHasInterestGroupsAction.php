<?php
namespace app\actions\clients;

use yii\rest\Action;
use app\helpers\ResponseHelper;
use app\apis\Auth;
use app\models\ClientHasInterestGroups;
use Yii;

class SaveClientHasInterestGroupsAction extends Action
{
    public $modelClass = 'app\models\Clients';

    public function run($id)
    {
        try {
            $client = $this->findModel($id);

            if(!$client) {
                throw new \Exception('El cliente no existe');
            }

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $client);
            }

            // Delete ClientHasInterestGroups
            foreach ($client->clientHasInterestGroups as $interestGroups) {
                $interestGroups->delete();
            }

            $interestGroupsId = Yii::$app->getRequest()->getBodyParams();

            if(!is_array($interestGroupsId)) {
                throw new Exception('Ingrese un array de interest_groups_id');
            }

            $response = [];
            // Save ClientHasInterestGroups
            foreach ($interestGroupsId as $interestGroupId) {
                $clientHasInterestGroup = new ClientHasInterestGroups();
                $clientHasInterestGroup->clients_id = $client->id;
                $clientHasInterestGroup->product_types_id = $interestGroupId;
                
                if($clientHasInterestGroup->save()) {
                    $response[] = $clientHasInterestGroup->getAttributes();
                } else {
                    $response[] = $clientHasInterestGroup->getErrors();
                }
            }

            return $response;
        } catch (\Throwable $th) {
            var_dump($th);die;
            return ResponseHelper::run(500, $th);
        }
    }
}
