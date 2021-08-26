<?php

use yii\db\Migration;

/**
 * Class m201206_022125_add_shipping_code_purchases_table
 */
class m201206_022125_add_shipping_code_purchases_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%purchases}}', 'shipping_code', $this->string(6));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201206_022125_add_shipping_code_purchases_table cannot be reverted.\n";
        $this->dropColumn('{{%purchases}}', 'shipping_code');

        return true;
    }
}
