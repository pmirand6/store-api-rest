<?php

use yii\db\Migration;

/**
 * Class m210220_040304_update_clients_table
 */
class m210220_040304_update_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%clients}}', 'dni', $this->integer());
        $this->alterColumn('{{%clients}}', 'phone_prefix', $this->string(5));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210220_040304_update_clients_table cannot be reverted.\n";

        return false;
    }

}
