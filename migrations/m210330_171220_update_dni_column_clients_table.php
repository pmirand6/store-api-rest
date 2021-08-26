<?php

use yii\db\Migration;

/**
 * Class m210330_171220_update_dni_column_clients_table
 */
class m210330_171220_update_dni_column_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%clients}}', 'dni', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210330_171220_update_dni_column_clients_table cannot be reverted.\n";

        return false;
    }
}
