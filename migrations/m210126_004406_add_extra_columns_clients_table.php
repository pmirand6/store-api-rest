<?php

use yii\db\Migration;

/**
 * Class m210126_004406_add_extra_columns_clients_table
 */
class m210126_004406_add_extra_columns_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%clients}}', 'gender', "ENUM('M', 'F', 'O')");
        $this->addColumn('{{%clients}}', 'lastname', $this->string(255));
        $this->addColumn('{{%clients%}}', 'phone_number', $this->double());
        $this->addColumn('{{%clients%}}', 'phone_prefix', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210126_004406_add_extra_columns_clients_table cannot be reverted.\n";

        $this->alterColumn('{{%clients}}', 'gender', "ENUM('M', 'F')");
        $this->dropColumn('{{%clients}}', 'lastname');
        $this->dropColumn('{{%clients}}', 'phone_number');
        $this->dropColumn('{{%clients}}', 'phone_prefix');

        return true;
    }
}
