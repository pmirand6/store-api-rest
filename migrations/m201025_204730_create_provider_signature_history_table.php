<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%provider_signature_history}}`.
 */
class m201025_204730_create_provider_signature_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%provider_signature_history}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'providers_id' => $this->bigInteger()->notNull(),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'ip' => $this->string(100),
            'user_agent' => $this->text(),
        ]);

        // creates index for column `providers_id`
        $this->createIndex(
            '{{%idx-provider_signature_history-providers_id}}',
            '{{%provider_signature_history}}',
            'providers_id'
        );

        // add foreign key for table `{{%providers}}`
        $this->addForeignKey(
            '{{%fk-provider_signature_history-providers_id}}',
            '{{%provider_signature_history}}',
            'providers_id',
            '{{%providers}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%providers}}`
        $this->dropForeignKey(
            '{{%fk-provider_signature_history-providers_id}}',
            '{{%provider_signature_history}}'
        );

        // drops index for column `providers_id`
        $this->dropIndex(
            '{{%idx-provider_signature_history-providers_id}}',
            '{{%provider_signature_history}}'
        );

        $this->dropTable('{{%provider_signature_history}}');

        return true;
    }
}
