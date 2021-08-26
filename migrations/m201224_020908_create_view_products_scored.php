<?php

use yii\db\Migration;

/**
 * Class m201224_020908_create_view_products_scored
 */
class m201224_020908_create_view_products_scored extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $sqlCreateView = <<< SQL
            CREATE VIEW products_scored AS
                SELECT
                    products.*,
                    ROUND( ( (SUM(product_score) + SUM(provider_score) + SUM(delivery_score)) / COUNT( qualifications.id )) / 3) AS score,
                    ROUND( SUM(product_score) / COUNT( qualifications.id ) ) AS product_score,
                    ROUND( SUM(provider_score) / COUNT( qualifications.id ) ) AS provider_score,
                    ROUND( SUM(delivery_score) / COUNT( qualifications.id ) )  AS delivery_score,
                    SUM( IF(qualifications.liked, 1, 0) ) AS liked,
                    SUM( IF(qualifications.liked, 0, 1) ) AS disliked,
                    COUNT( qualifications.id ) AS qualification_count
                FROM qualifications
                INNER JOIN purchases ON  purchases.id = qualifications.purchases_id
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
        echo "m201224_020908_create_view_products_scored cannot be reverted.\n";

        $sqlDeleteView = <<< SQL
            DROP VIEW products_scored;
        SQL;

        $this->execute($sqlDeleteView);
        
        return true;
    }

}