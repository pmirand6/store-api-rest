<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%views_history}}`.
 */
class m201010_155002_create_views_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%views_history}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'products_id' => $this->bigInteger()->notNull(),
            'clients_id' => $this->bigInteger()->notNull(),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `clients_id`
        $this->createIndex(
            '{{%idx-views_history-clients_id}}',
            '{{%views_history}}',
            'clients_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-views_history-clients_id}}',
            '{{%views_history}}',
            'clients_id',
            '{{%clients}}',
            'id',
            'CASCADE'
        );

        // creates index for column `products_id`
        $this->createIndex(
            '{{%idx-views_history-products_id}}',
            '{{%views_history}}',
            'products_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-views_history-products_id}}',
            '{{%views_history}}',
            'products_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%clients}}`
        $this->dropForeignKey(
            '{{%fk-views_history-clients_id}}',
            '{{%views_history}}'
        );

        // drops index for column `clients_id`
        $this->dropIndex(
            '{{%idx-views_history-clients_id}}',
            '{{%views_history}}'
        );
        
        // drops foreign key for table `{{%products}}`
        $this->dropForeignKey(
            '{{%fk-views_history-products_id}}',
            '{{%views_history}}'
        );

        // drops index for column `products_id`
        $this->dropIndex(
            '{{%idx-views_history-products_id}}',
            '{{%views_history}}'
        );
        
        $this->dropTable('{{%views_history}}');

        return true;
    }
}
