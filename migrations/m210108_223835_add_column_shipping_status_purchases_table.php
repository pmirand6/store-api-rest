<?php

use yii\db\Migration;

/**
 * Class m210108_223835_add_column_shipping_status_purchases_table
 */
class m210108_223835_add_column_shipping_status_purchases_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%purchases}}', 'shipping_status', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210108_223835_add_column_shipping_status_purchases_table cannot be reverted.\n";

        $this->dropColumn('{{%purchases}}', 'shipping_status');

        return true;
    }
}
