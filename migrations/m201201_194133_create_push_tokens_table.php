<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%push_tokens}}`.
 */
class m201201_194133_create_push_tokens_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%push_tokens}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'token' => $this->text()->notNull(),
            'users_id' => $this->bigInteger()->notNull(),
        ]);
        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-push_tokens-users_id}}',
            '{{%push_tokens}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-push_tokens-users_id}}',
            '{{%push_tokens}}',
            'users_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-push_tokens-users_id}}',
            '{{%push_tokens}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-push_tokens-users_id}}',
            '{{%push_tokens}}'
        );

        $this->dropTable('{{%push_tokens}}');

        return true;
    }
}
