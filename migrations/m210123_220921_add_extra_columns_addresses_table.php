<?php

use yii\db\Migration;

/**
 * Class m210123_220921_add_extra_columns_addresses_table
 */
class m210123_220921_add_extra_columns_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%addresses}}', 'name', $this->string(255));
        $this->addColumn('{{%addresses}}', 'floor', $this->string(100));
        $this->addColumn('{{%addresses}}', 'department', $this->string(100));
        $this->addColumn('{{%addresses}}', 'reference', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210123_220921_add_extra_columns_addresses_table cannot be reverted.\n";

        $this->dropColumn('{{%addresses}}', 'name');
        $this->dropColumn('{{%addresses}}', 'floor');
        $this->dropColumn('{{%addresses}}', 'department');
        $this->dropColumn('{{%addresses}}', 'reference');

        return true;
    }

}
