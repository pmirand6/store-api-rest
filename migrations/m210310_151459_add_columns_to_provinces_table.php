<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%provinces}}`.
 */
class m210310_151459_add_columns_to_provinces_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%provinces}}', 'code', $this->string(28)->notNull() );
        $this->addColumn('{{%provinces}}', 'active', $this->boolean()->defaultValue(1) );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%provinces}}', 'code');
        $this->dropColumn('{{%provinces}}', 'active');

        return true;
    }
}
