<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%purchase_orders}}`.
 */
class m201205_211411_create_purchase_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%purchase_orders}}', [
            'id' => $this->bigPrimaryKey(),
            'purchase_order_code' => $this->string(6)->notNull(),
            'clients_id' => $this->bigInteger()->notNull(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `clients_id`
        $this->createIndex(
            '{{%idx-purchase_orders-clients_id}}',
            '{{%purchase_orders}}',
            'clients_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-purchase_orders-clients_id}}',
            '{{%purchase_orders}}',
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
        // drops foreign key for table `{{%clients}}`
        $this->dropForeignKey(
            '{{%fk-purchase_orders-clients_id}}',
            '{{%purchase_orders}}'
        );

        // drops index for column `clients_id`
        $this->dropIndex(
            '{{%idx-purchase_orders-clients_id}}',
            '{{%purchase_orders}}'
        );
        
        $this->dropTable('{{%purchase_orders}}');

        return true;
    }
}
