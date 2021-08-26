<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%addresses}}`.
 */
class m210328_115325_drop_province_column_from_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%addresses}}', 'province');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%addresses}}', 'province', $this->string());
    }
}
