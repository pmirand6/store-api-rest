<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%localities}}`.
 */
class m210310_172635_add_columns_to_localities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%localities}}', 'code', $this->string(28)->notNull());
        $this->addColumn('{{%localities}}', 'active', $this->boolean()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%localities}}', 'code');
        $this->dropColumn('{{%localities}}', 'active');

        return true;
    }
}

