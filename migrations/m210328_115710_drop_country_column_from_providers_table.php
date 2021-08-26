<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%providers}}`.
 */
class m210328_115710_drop_country_column_from_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%providers}}', 'country');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%providers}}', 'country', $this->string());
    }
}
