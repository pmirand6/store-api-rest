<?php

use yii\db\Migration;

/**
 * Class m201205_231645_add_node_id_purchases_table
 */
class m201205_231645_add_node_id_purchases_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%purchases}}', 'node_id', $this->string(36));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201205_231645_add_node_id_purchases_table cannot be reverted.\n";
        $this->dropColumn('{{%purchases}}', 'node_id');

        return true;
    }
}
