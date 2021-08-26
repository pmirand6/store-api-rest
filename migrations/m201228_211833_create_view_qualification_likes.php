<?php

use yii\db\Migration;

/**
 * Class m201228_211833_create_view_qualification_likes
 */
class m201228_211833_create_view_qualification_likes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sqlCreateView = <<< SQL
            CREATE VIEW qualification_likes AS
                SELECT 
                    qualifications.*,
                    SUM(IF(qualification_votes.liked, 0, 1)) AS count_dislikes,
                    SUM(IF(qualification_votes.liked, 1, 0)) AS count_likes
                FROM qualifications
                INNER JOIN purchases ON purchases.id = qualifications.purchases_id
                INNER JOIN qualification_votes ON qualification_votes.qualifications_id = qualifications.id
                GROUP BY qualifications.id;
        SQL;

        $this->execute($sqlCreateView);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201228_211833_create_view_qualification_likes cannot be reverted.\n";

        $sqlDeleteView = <<< SQL
            DROP VIEW qualification_likes;
        SQL;

        $this->execute($sqlDeleteView);

        return true;
    }
}
