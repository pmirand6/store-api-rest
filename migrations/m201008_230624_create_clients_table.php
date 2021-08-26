<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients}}`.
 */
class m201008_230624_create_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clients}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'active' => $this->boolean()->defaultValue(true),
            'birth_date' => $this->date(),
            'dni' => $this->float(),
            'gender' => "ENUM('M', 'F')",
            'users_id' => $this->bigInteger()->notNull(),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-clients-users_id}}',
            '{{%clients}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-clients-users_id}}',
            '{{%clients}}',
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
        
        $this->dropTable('{{%clients}}');

        return true;
    }
}
