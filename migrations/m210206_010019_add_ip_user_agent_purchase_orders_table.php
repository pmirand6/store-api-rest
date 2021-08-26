<?php

use yii\db\Migration;

/**
 * Class m210206_010019_add_ip_user_agent_purchase_orders_table
 */
class m210206_010019_add_ip_user_agent_purchase_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->addColumn('{{%purchase_orders}}', 'ip', $this->string(100));
            $this->addColumn('{{%purchase_orders}}', 'user_agent', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210206_010019_add_ip_user_agent_purchase_orders_table cannot be reverted.\n";

        $this->dropColumn('{{%purchase_orders}}', 'ip');
        $this->dropColumn('{{%purchase_orders}}', 'user_agent');

        return true;
    }

}
