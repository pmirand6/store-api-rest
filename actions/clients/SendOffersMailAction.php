<?php
namespace app\actions\clients;

use yii\rest\Action;
use app\apis\Auth;
use app\helpers\ResponseHelper;
use app\models\Clients;
use app\models\Products;
use app\models\ProductImages;
use app\models\ViewsHistorySearch;


class SendOffersMailAction extends Action
{
    public $modelClass = 'app\models\Clients';

    /**
     * Obtener clientes que hayan hecho búsquedas en las últimas 24 hs, buscar productos similares y enviar mail.
     * TO-DO: añadir validación con tabla compras.
     */
    public function run()
    {
        try { 
            $dateTo   = date('Y-m-d H:i:s');
            $dateFrom = date('Y-m-d H:i:s', strtotime('-24 hour', strtotime($dateTo) ) );
            
            $viewsHistorySearchModel       = new ViewsHistorySearch();
            $params['select']              = ['MAX(views_history.date) as date','products.product_types_id as product_type'];
            $params['with']                = ['product'];
            $params['dateBetween']['from'] = $dateFrom;
            $params['dateBetween']['to']   = $dateTo;
            $params['groupBy']             = ['views_history.clients_id','products.product_types_id'];
            $clients = $viewsHistorySearchModel->search($params)['data'];
            $clients = $clients->getModels();

            $log = [];
            if($clients){
                foreach ($clients as $key => $search) {
                    $clientModel = Clients::findOne($search->clients_id);

                    $similarProducts = Products::find()
                                        ->select(['id', 'name', 'price', 'product_types_id', 
                                                  'product_image' => ProductImages::find()
                                                    ->select(['image'])
                                                    ->where('products_id=t.id')
                                                    ->limit(1)])
                                        ->where(['product_types_id'=>$search->product_type])
                                        ->limit(4)
                                        ->alias('t')
                                        ->all();
                    $log[$clientModel->id] = $clientModel->sendOffersMail($similarProducts);
                }
                return [ 'log' => $log ];
            }
        } catch (\Throwable $th) {
            return ResponseHelper::run(500, $th);
        }
    }
}

