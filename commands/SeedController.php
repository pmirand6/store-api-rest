<?php
namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use tebazil\yii2seeder\Seeder;

class SeedController extends Controller
{
    public function actionIndex()
    {
        try {
            $seeder = new Seeder();

            (new \app\seeds\LocalitiesSeed($seeder))->seed();
            (new \app\seeds\UsersSeed($seeder))->seed();
            (new \app\seeds\ProvidersSeed($seeder))->seed();
            (new \app\seeds\ProviderTypesSeed($seeder))->seed();
            (new \app\seeds\ProviderContactsSeed($seeder))->seed();
            (new \app\seeds\ProviderDeliveriesSeed($seeder))->seed();
            (new \app\seeds\ProviderTaxesSeed($seeder))->seed();
            (new \app\seeds\ProviderImagesSeed($seeder))->seed();
            (new \app\seeds\ProviderSignatureHistorySeed($seeder))->seed();
            (new \app\seeds\ProductTypesSeed($seeder))->seed();
            (new \app\seeds\SubproductTypificationsSeed($seeder))->seed();
            (new \app\seeds\SubproductTypesSeed($seeder))->seed();
            (new \app\seeds\ProductsSeed($seeder))->seed();
            (new \app\seeds\ProductImagesSeed($seeder))->seed();
            (new \app\seeds\DeliveryTypesSeed($seeder))->seed();
            (new \app\seeds\ProductsHasDeliveryTypesSeed($seeder))->seed();
            (new \app\seeds\ContractsSeed($seeder))->seed();
            (new \app\seeds\ClientsSeed($seeder))->seed();
            (new \app\seeds\FavoritesSeed($seeder))->seed();
            (new \app\seeds\AddressesSeed($seeder))->seed();
            (new \app\seeds\ClientSignatureHistorySeed($seeder))->seed();
            (new \app\seeds\FavoritesLogSeed($seeder))->seed();
            (new \app\seeds\ViewsHistorySeed($seeder))->seed();
            (new \app\seeds\PurchasesSeed($seeder))->seed();
            (new \app\seeds\QualificationsSeed($seeder))->seed();
            (new \app\seeds\QualificationVotesSeed($seeder))->seed();
            
            $seeder->refill();
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }

        return ExitCode::OK;
    }
}
