<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%purchases}}`.
 */
class m201028_002046_create_purchases_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%purchases}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'clients_id' => $this->bigInteger()->notNull(),
            'products_id' => $this->bigInteger()->notNull(),
            'delivery_types_id' => $this->bigInteger()->notNull(),
            'addresses_id' => $this->bigInteger()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'delivery_cost' => $this->double()->defaultValue(0),
            'service_cost' => $this->double()->defaultValue(0),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `clients_id`
        $this->createIndex(
            '{{%idx-purchases-clients_id}}',
            '{{%purchases}}',
            'clients_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-purchases-clients_id}}',
            '{{%purchases}}',
            'clients_id',
            '{{%clients}}',
            'id',
            'CASCADE'
        );

        // creates index for column `products_id`
        $this->createIndex(
            '{{%idx-purchases-products_id}}',
            '{{%purchases}}',
            'products_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-purchases-products_id}}',
            '{{%purchases}}',
            'products_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );

        // creates index for column `delivery_types_id`
        $this->createIndex(
            '{{%idx-purchases-delivery_types_id}}',
            '{{%purchases}}',
            'delivery_types_id'
        );

        // add foreign key for table `{{%delivery_types}}`
        $this->addForeignKey(
            '{{%fk-purchases-delivery_types_id}}',
            '{{%purchases}}',
            'delivery_types_id',
            '{{%delivery_types}}',
            'id',
            'CASCADE'
        );

        // creates index for column `addresses_id`
        $this->createIndex(
            '{{%idx-purchases-addresses_id}}',
            '{{%purchases}}',
            'addresses_id'
        );

        // add foreign key for table `{{%addresses}}`
        $this->addForeignKey(
            '{{%fk-purchases-addresses_id}}',
            '{{%purchases}}',
            'addresses_id',
            '{{%addresses}}',
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
            '{{%fk-purchases-clients_id}}',
            '{{%purchases}}'
        );

        // drops index for column `clients_id`
        $this->dropIndex(
            '{{%idx-purchases-clients_id}}',
            '{{%purchases}}'
        );

        // drops foreign key for table `{{%products}}`
        $this->dropForeignKey(
            '{{%fk-purchases-products_id}}',
            '{{%purchases}}'
        );

        // drops index for column `products_id`
        $this->dropIndex(
            '{{%idx-purchases-products_id}}',
            '{{%purchases}}'
        );
        
        // drops foreign key for table `{{%delivery_types}}`
        $this->dropForeignKey(
            '{{%fk-purchases-delivery_types_id}}',
            '{{%purchases}}'
        );

        // drops index for column `delivery_types_id`
        $this->dropIndex(
            '{{%idx-purchases-delivery_types_id}}',
            '{{%purchases}}'
        );
        
        // drops foreign key for table `{{%addresses}}`
        $this->dropForeignKey(
            '{{%fk-purchases-addresses_id}}',
            '{{%purchases}}'
        );

        // drops index for column `addresses_id`
        $this->dropIndex(
            '{{%idx-purchases-addresses_id}}',
            '{{%purchases}}'
        );

        $this->dropTable('{{%purchases}}');

        return true;
    }
}
