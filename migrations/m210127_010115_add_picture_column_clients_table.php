<?php

use yii\db\Migration;

/**
 * Class m210127_010115_add_picture_column_clients_table
 */
class m210127_010115_add_picture_column_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'picture', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210127_010115_add_picture_column_clients_table cannot be reverted.\n";

        $this->dropColumn('{{%clients}}', 'picture');

        return true;
    }
}
