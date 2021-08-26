<?php

use yii\db\Migration;

/**
 * Class m210105_013912_update_view_products_scored
 */
class m210105_013912_update_view_products_scored extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // DELETE view
        $sqlDeleteView = <<< SQL
            DROP VIEW IF EXISTS products_scored;
        SQL;

        $this->execute($sqlDeleteView);

        // Create View
        $sqlCreateView = <<< SQL
            CREATE VIEW products_scored AS
            SELECT
                products.*,
                ROUND( ( (SUM(product_score) + SUM(provider_score) + SUM(delivery_score)) / COUNT( qualifications.id )) / 3) AS score,
                SUM(IF(qualifications.product_score = 0, 1, 0)) AS product_score_zero,
                SUM(IF(qualifications.provider_score = 0, 1, 0)) AS provider_score_zero,
                SUM(IF(qualifications.delivery_score = 0, 1, 0)) AS delivery_score_zero,
                SUM(IF(qualifications.product_score = 1, 1, 0)) AS product_score_one,
                SUM(IF(qualifications.provider_score = 1, 1, 0)) AS provider_score_one,
                SUM(IF(qualifications.delivery_score = 1, 1, 0)) AS delivery_score_one,
                SUM(IF(qualifications.product_score = 2, 1, 0)) AS product_score_two,
                SUM(IF(qualifications.provider_score = 2, 1, 0)) AS provider_score_two,
                SUM(IF(qualifications.delivery_score = 2, 1, 0)) AS delivery_score_two,
                SUM(IF(qualifications.product_score = 3, 1, 0)) AS product_score_three,
                SUM(IF(qualifications.provider_score = 3, 1, 0)) AS provider_score_three,
                SUM(IF(qualifications.delivery_score = 3, 1, 0)) AS delivery_score_three,
                SUM(IF(qualifications.product_score = 4, 1, 0)) AS product_score_four,
                SUM(IF(qualifications.provider_score = 4, 1, 0)) AS provider_score_four,
                SUM(IF(qualifications.delivery_score = 4, 1, 0)) AS delivery_score_four,
                SUM(IF(qualifications.product_score = 5, 1, 0)) AS product_score_five,
                SUM(IF(qualifications.provider_score = 5, 1, 0)) AS provider_score_five,
                SUM(IF(qualifications.delivery_score = 5, 1, 0)) AS delivery_score_five,
                COUNT(qualifications.id) AS qualification_count,
                SUM( IF(qualifications.liked, 1, 0) ) AS liked,
                SUM( IF(qualifications.liked, 0, 1) ) AS disliked
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
        echo "m210105_013912_update_view_products_scored cannot be reverted.\n";

        $sqlDeleteView = <<< SQL
            DROP VIEW products_scored;
        SQL;

        $this->execute($sqlDeleteView);

        return true;
    }

}
