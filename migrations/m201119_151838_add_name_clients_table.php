<?php

use yii\db\Migration;

/**
 * Class m201119_151838_add_name_clients_table
 */
class m201119_151838_add_name_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'name', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201119_151838_add_name_clients_table cannot be reverted.\n";

        $this->dropColumn('{{%clients}}', 'name');

        return true;
    }
}
