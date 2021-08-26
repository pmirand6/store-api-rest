<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%questions}}`.
 */
class m210105_235622_create_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%questions}}', [
            'id' => $this->bigPrimaryKey(),
            'products_id' => $this->bigInteger()->notNull(),
            'clients_id' => $this->bigInteger()->notNull(),
            'question' => $this->text(),
            'answer' => $this->text(),
            'questioned_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'answered_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp(),
        ]);

        // creates index for column `products_id`
        $this->createIndex(
            '{{%idx-questions-products_id}}',
            '{{%questions}}',
            'products_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-questions-products_id}}',
            '{{%questions}}',
            'products_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );

        // creates index for column `clients_id`
        $this->createIndex(
            '{{%idx-questions-clients_id}}',
            '{{%questions}}',
            'clients_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-questions-clients_id}}',
            '{{%questions}}',
            'clients_id',
            '{{%clients}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%questions}}`
        $this->dropForeignKey(
            '{{%fk-questions-products_id}}',
            '{{%questions}}'
        );

        // drops index for column `products_id`
        $this->dropIndex(
            '{{%idx-questions-products_id}}',
            '{{%questions}}'
        );

        // drops foreign key for table `{{%questions}}`
        $this->dropForeignKey(
            '{{%fk-questions-clients_id}}',
            '{{%questions}}'
        );

        // drops index for column `clients_id`
        $this->dropIndex(
            '{{%idx-questions-clients_id}}',
            '{{%questions}}'
        );

        $this->dropTable('{{%questions}}');
    }
}
