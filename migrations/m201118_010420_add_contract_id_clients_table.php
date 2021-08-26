<?php

use yii\db\Migration;

/**
 * Class m201118_010420_add_contract_id_clients_table
 */
class m201118_010420_add_contract_id_clients_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'contracts_id', $this->bigInteger());

        // creates index for column `contracts_id`
        $this->createIndex(
            '{{%idx-clients-contracts_id}}',
            '{{%clients}}',
            'contracts_id'
        );

        // add foreign key for table `{{%contracts}}`
        $this->addForeignKey(
            '{{%fk-clients-contracts_id}}',
            '{{%clients}}',
            'contracts_id',
            '{{%contracts}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201118_010037_add_contract_id_clients_table cannot be reverted.\n";

        // drops foreign key for table `{{%clients}}`
        $this->dropForeignKey(
            '{{%fk-clients-contracts_id}}',
            '{{%clients}}'
        );

        // drops index for column `contracts_id`
        $this->dropIndex(
            '{{%idx-clients-contracts_id}}',
            '{{%clients}}'
        );

        $this->dropColumn('{{%clients}}', 'contracts_id');

        return true;
    }
}
