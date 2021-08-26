<?php

use yii\db\Migration;

/**
 * Class m210117_194714_add_shipping_status_code_purchases_table
 */
class m210117_194714_add_shipping_status_code_purchases_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%purchases}}', 'shipping_status_code', $this->string(255));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210117_194714_add_shipping_status_code_purchases_table cannot be reverted.\n";

        $this->dropColumn('{{%purchases}}', 'shipping_status_code');
        
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210117_194714_add_shipping_status_code_purchases_table cannot be reverted.\n";

        return false;
    }
    */
}
