<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorites}}`.
 */
class m201010_000218_create_favorites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorites}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'clients_id' => $this->bigInteger()->notNull(),
            'products_id' => $this->bigInteger()->notNull(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `clients_id`
        $this->createIndex(
            '{{%idx-favorites-clients_id}}',
            '{{%favorites}}',
            'clients_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-favorites-clients_id}}',
            '{{%favorites}}',
            'clients_id',
            '{{%clients}}',
            'id',
            'CASCADE'
        );

        // creates index for column `products_id`
        $this->createIndex(
            '{{%idx-favorites-products_id}}',
            '{{%favorites}}',
            'products_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-favorites-products_id}}',
            '{{%favorites}}',
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
            '{{%fk-favorites-clients_id}}',
            '{{%favorites}}'
        );

        // drops index for column `clients_id`
        $this->dropIndex(
            '{{%idx-favorites-clients_id}}',
            '{{%favorites}}'
        );
        
        // drops foreign key for table `{{%products}}`
        $this->dropForeignKey(
            '{{%fk-favorites-products_id}}',
            '{{%favorites}}'
        );

        // drops index for column `products_id`
        $this->dropIndex(
            '{{%idx-favorites-products_id}}',
            '{{%favorites}}'
        );
        
        $this->dropTable('{{%favorites}}');

        return true;
    }
}
