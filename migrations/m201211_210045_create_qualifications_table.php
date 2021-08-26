<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%qualifications}}`.
 */
class m201211_210045_create_qualifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%qualifications}}', [
            'id' => $this->bigPrimaryKey(),
            'purchases_id' => $this->bigInteger()->notNull(),
            'liked' => $this->boolean(),
            'product_score' => $this->integer(1),
            'delivery_score' => $this->integer(1),
            'provider_score' => $this->integer(1),
            'comment' => $this->text(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `purchases_id`
        $this->createIndex(
            '{{%idx-qualifications-purchases_id}}',
            '{{%qualifications}}',
            'purchases_id'
        );

        // add foreign key for table `{{%purchases}}`
        $this->addForeignKey(
            '{{%fk-qualifications-purchases_id}}',
            '{{%qualifications}}',
            'purchases_id',
            '{{%purchases}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%purchases}}`
        $this->dropForeignKey(
            '{{%fk-qualifications-purchases_id}}',
            '{{%qualifications}}'
        );

        // drops index for column `purchases_id`
        $this->dropIndex(
            '{{%idx-qualifications-purchases_id}}',
            '{{%qualifications}}'
        );
        
        $this->dropTable('{{%qualifications}}');

        return true;
    }
}
