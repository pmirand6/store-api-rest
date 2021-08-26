<?php

use yii\db\Migration;

/**
 * Class m201215_013616_create_view_product_qualifications
 */
class m201215_013616_create_view_product_qualifications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sqlCreateView = <<< SQL
            CREATE VIEW product_qualifications AS
                SELECT 
                    products.id, 
                    count(qualifications.id) AS quantity, 
                    SUM(product_score) / count(qualifications.id) AS product_score,
                    SUM(delivery_score) / count(qualifications.id) AS delivery_score,
                    SUM(provider_score) / count(qualifications.id) AS provider_score,
                    SUM(IF(qualifications.liked, 1, 0)) AS liked,
                    SUM(IF(qualifications.liked = false, 1, 0)) AS disliked
                FROM qualifications
                INNER JOIN purchases ON purchases.id = qualifications.purchases_id
                INNER JOIN products ON products.id = purchases.products_id
                GROUP BY products.id;
        SQL;

        $this->execute($sqlCreateView);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201215_013616_create_view_product_qualifications cannot be reverted.\n";

        $sqlDeleteView = <<< SQL
            DROP VIEW product_qualifications;
        SQL;

        $this->execute($sqlDeleteView);

        return true;
    }
}
