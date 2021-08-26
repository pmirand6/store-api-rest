<?php

use yii\db\Migration;

/**
 * Class m201224_022539_create_view_products_scored_two
 */
class m201224_022539_create_view_products_scored_two extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sqlCreateView = <<< SQL
            CREATE VIEW products_scored_two AS
                SELECT
                    products.*,
                    ROUND( SUM(qualifications.product_score) / COUNT(qualifications.id) ) AS product_score,
                    ROUND( SUM(qualifications.provider_score) / COUNT(qualifications.id) ) AS provider_score,
                    ROUND( SUM(qualifications.delivery_score) / COUNT(qualifications.id) ) AS delivery_score,
                    COUNT(qualifications.id) AS qualification_count
                FROM qualifications
                INNER JOIN purchases ON  purchases.id = qualifications.purchases_id
                INNER JOIN products ON products.id = purchases.products_id
                WHERE ROUND( (product_score + provider_score + delivery_score)/3 ) = 2
                GROUP BY products.id
        SQL;

        $this->execute($sqlCreateView);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201224_022539_create_view_products_scored_two cannot be reverted.\n";

        $sqlDeleteView = <<< SQL
            DROP VIEW products_scored_two;
        SQL;

        $this->execute($sqlDeleteView);

        return true;
    }
}
