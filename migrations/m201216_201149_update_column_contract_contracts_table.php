<?php

use yii\db\Migration;

/**
 * Class m201216_201149_update_column_contract_contracts_table
 */
class m201216_201149_update_column_contract_contracts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%contracts}}', 'contract', 'LONGTEXT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201216_201149_update_column_contract_contracts_table cannot be reverted.\n";

        $this->alterColumn('{{%contracts}}', 'contract', $this->text());

        return true;
    }
}
