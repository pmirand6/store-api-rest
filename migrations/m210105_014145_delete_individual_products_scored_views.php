<?php

use yii\db\Migration;

/**
 * Class m210105_014145_delete_individual_products_scored_views
 */
class m210105_014145_delete_individual_products_scored_views extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $sqlDeleteView = <<< SQL
            DROP VIEW IF EXISTS products_scored_zero;
            DROP VIEW IF EXISTS products_scored_one;
            DROP VIEW IF EXISTS products_scored_two;
            DROP VIEW IF EXISTS products_scored_three;
            DROP VIEW IF EXISTS products_scored_four;
            DROP VIEW IF EXISTS products_scored_five;
        SQL;

        $this->execute($sqlDeleteView);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210105_014145_delete_individual_products_scored_views cannot be reverted.\n";

        return true;
    }

}
