<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%providers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m200930_124307_add_users_id_column_to_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%providers}}', 'users_id', $this->bigInteger()->notNull());

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-providers-users_id}}',
            '{{%providers}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-providers-users_id}}',
            '{{%providers}}',
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

        $this->dropColumn('{{%providers}}', 'users_id');

        return true;
    }
}
