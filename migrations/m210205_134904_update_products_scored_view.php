<?php

use yii\db\Migration;

/**
 * Class m210205_134904_update_products_scored_view
 */
class m210205_134904_update_products_scored_view extends Migration
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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210205_134904_update_products_scored_view cannot be reverted.\n";

        $sqlDeleteView = <<< SQL
            DROP VIEW IF EXISTS products_scored;
        SQL;

        $this->execute($sqlDeleteView);

        $sqlCreateView = <<< SQL
            CREATE VIEW products_scored AS
                SELECT
                    products.*,
                    ROUND( ( (SUM(product_score) + SUM(provider_score) + SUM(delivery_score)) / COUNT( qualifications.id )) / 3) AS score,
                    ROUND( SUM(product_score) / COUNT( qualifications.id ) ) AS product_score,
                    ROUND( SUM(provider_score) / COUNT( qualifications.id ) ) AS provider_score,
                    ROUND( SUM(delivery_score) / COUNT( qualifications.id ) )  AS delivery_score,
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
