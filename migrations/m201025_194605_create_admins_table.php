<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admins}}`.
 */
class m201025_194605_create_admins_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admins}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'active' => $this->boolean()->defaultValue(true),
            'users_id' => $this->bigInteger()->notNull(),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-admins-users_id}}',
            '{{%admins}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-admins-users_id}}',
            '{{%admins}}',
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
            '{{%fk-providers-users_id}}',
            '{{%providers}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-providers-users_id}}',
            '{{%providers}}'
        );
        
        $this->dropTable('{{%admins}}');

        return true;
    }
}
