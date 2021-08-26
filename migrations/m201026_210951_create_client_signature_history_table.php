<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_signature_history}}`.
 */
class m201026_210951_create_client_signature_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_signature_history}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'clients_id' => $this->bigInteger()->notNull(),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'ip' => $this->string(100),
            'user_agent' => $this->text(),
        ]);

        // creates index for column `clients_id`
        $this->createIndex(
            '{{%idx-client_signature_history-clients_id}}',
            '{{%client_signature_history}}',
            'clients_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-client_signature_history-clients_id}}',
            '{{%client_signature_history}}',
            'clients_id',
            '{{%clients}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%clients}}`
        $this->dropForeignKey(
            '{{%fk-client_signature_history-clients_id}}',
            '{{%client_signature_history}}'
        );

        // drops index for column `clients_id`
        $this->dropIndex(
            '{{%idx-client_signature_history-clients_id}}',
            '{{%client_signature_history}}'
        );

        $this->dropTable('{{%client_signature_history}}');

        return true;
    }
}
