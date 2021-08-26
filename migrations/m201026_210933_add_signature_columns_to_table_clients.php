<?php

use yii\db\Migration;

/**
 * Class m201026_210933_add_signature_columns_to_table_clients
 */
class m201026_210933_add_signature_columns_to_table_clients extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'signature', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%clients}}', 'signature_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201026_210933_add_signature_columns_to_table_clients cannot be reverted.\n";

        $this->dropColumn('{{%clients}}', 'signature');
        $this->dropColumn('{{%clients}}', 'signature_date');

        return true;
    }

}
