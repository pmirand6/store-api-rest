<?php

use yii\db\Migration;

/**
 * Class m201224_022442_create_view_products_scored_three
 */
class m201224_022442_create_view_products_scored_three extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sqlCreateView = <<< SQL
            CREATE VIEW products_scored_three AS
                SELECT
                    products.*,
                    ROUND( SUM(qualifications.product_score) / COUNT(qualifications.id) ) AS product_score,
                    ROUND( SUM(qualifications.provider_score) / COUNT(qualifications.id) ) AS provider_score,
                    ROUND( SUM(qualifications.delivery_score) / COUNT(qualifications.id) ) AS delivery_score,
                    COUNT(qualifications.id) AS qualification_count
                FROM qualifications
                INNER JOIN purchases ON  purchases.id = qualifications.purchases_id
                INNER JOIN products ON products.id = purchases.products_id
                WHERE ROUND( (product_score + provider_score + delivery_score)/3 ) = 3
                GROUP BY products.id
        SQL;

        $this->execute($sqlCreateView);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201224_022442_create_view_products_scored_three cannot be reverted.\n";

        $sqlDeleteView = <<< SQL
            DROP VIEW products_scored_three;
        SQL;

        $this->execute($sqlDeleteView);

        return true;
    }
}
