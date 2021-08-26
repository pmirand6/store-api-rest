<?php

use yii\db\Migration;

/**
 * Class m201217_224833_add_columns_bank_and_account_provider_taxes_table
 */
class m201217_224833_add_columns_bank_and_account_provider_taxes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%provider_taxes}}', 'bank', $this->string(255));
        $this->addColumn('{{%provider_taxes}}', 'account', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201217_224833_add_columns_bank_and_account_provider_taxes_table cannot be reverted.\n";

        $this->dropColumn('{{%provider_taxes}}', 'bank');
        $this->dropColumn('{{%provider_taxes}}', 'account');

        return true;
    }
}
