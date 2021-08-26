<?php

use yii\db\Migration;

/**
 * Class m210117_143136_add_column_status_purchase_orders_table
 */
class m210117_143136_add_column_status_purchase_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%purchase_orders}}', 'status', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210117_143136_add_column_status_purchase_orders_table cannot be reverted.\n";

        $this->dropColumn('{{%purchase_orders}}', 'status');

        return false;
    }
}
