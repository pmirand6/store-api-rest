<?php

use yii\db\Migration;

/**
 * Class m210330_171949_update_dni_column_providers_table
 */
class m210330_171949_update_dni_column_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%providers}}', 'dni', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210330_171949_update_dni_column_providers_table cannot be reverted.\n";

        return false;
    }
}
