<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%providers}}`.
 */
class m210328_115441_drop_province_column_from_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%providers}}', 'province');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%providers}}', 'province', $this->string());
    }
}
