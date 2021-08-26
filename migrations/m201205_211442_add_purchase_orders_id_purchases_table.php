<?php

use yii\db\Migration;

/**
 * Class m201205_211442_add_purchase_orders_id_purchases_table
 */
class m201205_211442_add_purchase_orders_id_purchases_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%purchases}}', 'purchase_orders_id', $this->bigInteger());
        $this->addColumn('{{%purchases}}', 'purchase_code', $this->string(6)->notNull());

        // creates index for column `purchase_orders_id`
        $this->createIndex(
            '{{%idx-purchases-purchase_orders_id}}',
            '{{%purchases}}',
            'purchase_orders_id'
        );

        // add foreign key for table `{{%purchase_orders}}`
        $this->addForeignKey(
            '{{%fk-purchases-purchase_orders_id}}',
            '{{%purchases}}',
            'purchase_orders_id',
            '{{%purchase_orders}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201205_211442_add_purchase_orders_id_purchases_table cannot be reverted.\n";

        // drops foreign key for table `{{%purchases}}`
        $this->dropForeignKey(
            '{{%fk-purchases-purchase_orders_id}}',
            '{{%purchases}}'
        );

        // drops index for column `purchase_orders_id`
        $this->dropIndex(
            '{{%idx-purchases-purchase_orders_id}}',
            '{{%purchases}}'
        );
        
        $this->dropColumn('{{%purchases}}', 'purchase_orders_id');
        $this->dropColumn('{{%purchases}}', 'purchase_code');

        return true;
    }

}
