<?php

use yii\db\Migration;

/**
 * Class m201217_225023_update_provider_taxes_lenght_table
 */
class m201217_225023_update_provider_taxes_lenght_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%provider_taxes}}', 'qualification', $this->string(250));
        $this->alterColumn('{{%provider_taxes}}', 'qualification_notes', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201217_225023_update_provider_taxes_lenght_table cannot be reverted.\n";

        return true;
    }
}
