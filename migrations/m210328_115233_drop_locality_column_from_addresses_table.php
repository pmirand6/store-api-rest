<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%addresses}}`.
 */
class m210328_115233_drop_locality_column_from_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%addresses}}', 'locality');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%addresses}}', 'locality', $this->string());
    }
}
