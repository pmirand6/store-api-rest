<?php

use yii\db\Migration;

/**
 * Class m201118_010037_add_contract_id_providers_table
 */
class m201118_010037_add_contract_id_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%providers}}', 'contracts_id', $this->bigInteger());

        // creates index for column `contracts_id`
        $this->createIndex(
            '{{%idx-providers-contracts_id}}',
            '{{%providers}}',
            'contracts_id'
        );

        // add foreign key for table `{{%contracts}}`
        $this->addForeignKey(
            '{{%fk-providers-contracts_id}}',
            '{{%providers}}',
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
        echo "m201118_010037_add_contract_id_providers_table cannot be reverted.\n";

        // drops foreign key for table `{{%providers}}`
        $this->dropForeignKey(
            '{{%fk-providers-contracts_id}}',
            '{{%providers}}'
        );

        // drops index for column `contracts_id`
        $this->dropIndex(
            '{{%idx-providers-contracts_id}}',
            '{{%providers}}'
        );
        
        $this->dropColumn('{{%providers}}', 'contracts_id');

        return true;
    }
}
