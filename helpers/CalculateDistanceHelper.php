<?php


namespace app\helpers;


/**
 * Class CalculateDistanceHelper
 * @package app\helpers
 */
class CalculateDistanceHelper
{
    /**
     * @param $point1
     * @param $point2
     * @return float|string
     */
    public function __invoke($point1, $point2)
    {
        try {
            $query = (new \yii\db\Query())
                ->select(["ST_Distance(:point1,:point2) as distance"])
                ->params([
                    ':point1' => $point1,
                    ':point2' => $point2
                ]);
            $command = $query->createCommand();
            $rows = $command->queryAll();

            return round($rows[0]["distance"] / 1000, 2);

        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}