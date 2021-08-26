<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%addresses}}`.
 */
class m210328_115309_drop_city_column_from_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%addresses}}', 'city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%addresses}}', 'city', $this->string());
    }
}
