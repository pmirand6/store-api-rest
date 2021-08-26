<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%addresses}}`.
 */
class m210328_115738_drop_country_column_from_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%addresses}}', 'country');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%addresses}}', 'country', $this->string());
    }
}
