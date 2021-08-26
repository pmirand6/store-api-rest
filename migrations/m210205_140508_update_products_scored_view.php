<?php

use yii\db\Migration;

/**
 * Class m210205_140508_update_products_scored_view
 */
class m210205_140508_update_products_scored_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $sqlDeleteView = <<< SQL
            DROP VIEW IF EXISTS products_scored;
        SQL;

        $this->execute($sqlDeleteView);

        $sqlCreateView = <<< SQL
            CREATE VIEW products_scored AS
            SELECT
                products.*,
                (( SUM(product_score) + SUM(provider_score) + SUM(delivery_score) ) / COUNT( qualifications.id )) / 3 AS score,
                SUM(product_score) / COUNT( qualifications.id ) AS product_score,
                SUM(provider_score) / COUNT( qualifications.id ) AS provider_score,
                SUM(delivery_score) / COUNT( qualifications.id )  AS delivery_score,
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
                SUM( IF(qualifications.liked = 1, 1, 0) ) AS liked,
                SUM( IF(qualifications.liked = 0, 1, 0) ) AS disliked,
                COUNT( qualifications.id ) AS qualification_count,
                ( date(IFNULL(products.updated_at, products.created_at)) <= (curdate()) ) AND ( date(IFNULL(products.updated_at, products.created_at)) >= ( curdate() - INTERVAL DAYOFWEEK( curdate() ) + 7 DAY ) ) AS new,
                IF(products.expires, DATE_ADD(DATE(IFNULL(products.updated_at, products.created_at)), INTERVAL products.expires_time DAY), NULL) AS expires_date
            FROM qualifications
            INNER JOIN purchases ON  purchases.id = qualifications.purchases_id
            RIGHT JOIN products ON products.id = purchases.products_id
            GROUP BY products.id;
        SQL;

        $this->execute($sqlCreateView);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210205_140508_update_products_scored_view cannot be reverted.\n";

        $sqlDeleteView = <<< SQL
            DROP VIEW IF EXISTS products_scored;
        SQL;

        $this->execute($sqlDeleteView);

        $sqlCreateView = <<< SQL
            CREATE VIEW products_scored AS
                SELECT
                    products.*,
                    ( SUM(product_score) + SUM(provider_score) + SUM(delivery_score) ) / (COUNT( qualifications.id ) / 3) AS score,
                    SUM(product_score) / COUNT( qualifications.id ) AS product_score,
                    SUM(provider_score) / COUNT( qualifications.id ) AS provider_score,
                    SUM(delivery_score) / COUNT( qualifications.id )  AS delivery_score,
                    SUM( IF(qualifications.liked = 1, 1, 0) ) AS liked,
                    SUM( IF(qualifications.liked = 0, 1, 0) ) AS disliked,
                    COUNT( qualifications.id ) AS qualification_count,
                    ( date(IFNULL(products.updated_at, products.created_at)) <= (curdate()) ) AND ( date(IFNULL(products.updated_at, products.created_at)) >= ( curdate() - INTERVAL DAYOFWEEK( curdate() ) + 7 DAY ) ) AS new,
                    IF(products.expires, DATE_ADD(DATE(IFNULL(products.updated_at, products.created_at)), INTERVAL products.expires_time DAY), NULL) AS expires_date
                FROM qualifications
                INNER JOIN purchases ON  purchases.id = qualifications.purchases_id
                RIGHT JOIN products ON products.id = purchases.products_id
                GROUP BY products.id;
        SQL;

        $this->execute($sqlCreateView);

        return true;
    }

}
