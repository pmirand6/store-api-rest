<?php

use yii\db\Migration;

/**
 * Class m210204_171816_remove_bank_info_providers_table
 */
class m210204_171816_remove_bank_info_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropColumn('{{%providers}}', 'cbu');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210204_171816_remove_bank_info_providers_table cannot be reverted.\n";

        $this->addColumn('{{%providers}}', 'cbu', $this->string(22)->notNull());

        return true;
    }

}
