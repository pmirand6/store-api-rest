<?php

use yii\db\Migration;

/**
 * Class m210111_172409_update_column_number_provider_taxes_table
 */
class m210111_172409_update_column_number_provider_taxes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%provider_taxes}}', 'number', $this->string(30));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210111_172409_update_column_number_provider_taxes_table cannot be reverted.\n";

        $this->alterColumn('{{%provider_taxes}}', 'number', $this->notNull()->string(30));

        return true;
    }
}
