<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%providers}}`.
 */
class m210328_115517_drop_locality_column_from_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%providers}}', 'locality');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%providers}}', 'locality', $this->string());
    }
}
