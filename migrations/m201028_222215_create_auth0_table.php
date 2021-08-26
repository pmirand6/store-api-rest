<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth0}}`.
 */
class m201028_222215_create_auth0_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth0}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'users_id' => $this->bigInteger()->notNull(),
            'sub' => $this->string(100)->notNull(),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-auth0-users_id}}',
            '{{%auth0}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-auth0-users_id}}',
            '{{%auth0}}',
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
            '{{%fk-auth0-users_id}}',
            '{{%auth0}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-auth0-users_id}}',
            '{{%auth0}}'
        );
        
        $this->dropTable('{{%auth0}}');

        return true;
    }
}
