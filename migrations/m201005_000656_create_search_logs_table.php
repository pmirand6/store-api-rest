<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%search_logs}}`.
 */
class m201005_000656_create_search_logs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%search_logs}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'query' => $this->text(),
            'users_id' => $this->bigInteger(),
            'date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-search_logs-users_id}}',
            '{{%search_logs}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-search_logs-users_id}}',
            '{{%search_logs}}',
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
        $this->dropTable('{{%search_logs}}');

        return true;
    }
}
