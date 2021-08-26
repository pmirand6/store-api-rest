<?php

use yii\db\Migration;

/**
 * Class m210123_175619_add_column_principal_addressses_table
 */
class m210123_175619_add_column_principal_addressses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%addresses}}', 'principal', $this->boolean()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210123_175619_add_column_principal_addressses_table cannot be reverted.\n";

        $this->dropColumn('{{%addresses}}', 'principal');
        
        return true;
    }
}
