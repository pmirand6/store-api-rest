<?php

use yii\db\Migration;

/**
 * Class m210115_005519_remove_street_name_providers_table
 */
class m210115_005519_remove_street_name_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%providers}}', 'street_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210115_005519_remove_street_name_providers_table cannot be reverted.\n";

        $this->addColumn('{{%providers}}', 'formatted_address', $this->string(30)->notNull());
        
        return true;
    }
}
