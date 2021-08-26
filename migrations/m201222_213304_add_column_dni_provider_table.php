<?php

use yii\db\Migration;

/**
 * Class m201222_213304_add_column_dni_provider_table
 */
class m201222_213304_add_column_dni_provider_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%providers}}', 'dni', $this->double());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201222_213304_add_column_dni_provider_table cannot be reverted.\n";

        $this->dropColumn('{{%providers}}', 'dni');

        return true;
    }

}
