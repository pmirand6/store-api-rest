<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%providers}}`.
 */
class m210328_115456_drop_city_column_from_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%providers}}', 'city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%providers}}', 'city', $this->string());
    }
}
