<?php

use yii\db\Migration;

/**
 * Class m210204_172504_remove_bank_info_providers_taxes_table
 */
class m210204_172504_remove_bank_info_providers_taxes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%provider_taxes}}', 'bank');
        $this->dropColumn('{{%provider_taxes}}', 'account');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210204_172504_remove_bank_info_providers_taxes_table cannot be reverted.\n";

        $this->addColumn('{{%provider_taxes}}', 'bank', $this->string(255));
        $this->addColumn('{{%provider_taxes}}', 'account', $this->string(255));

        return true;
    }
}
