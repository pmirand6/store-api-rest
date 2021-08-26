<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%localities}}`.
 */
class m201021_010019_create_localities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%localities}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'provinces_id' => $this->bigInteger()->notNull(),
            'locality' => $this->string(255)->notNull(),
        ]);

        // creates index for column `provinces_id`
        $this->createIndex(
            '{{%idx-localities-provinces_id}}',
            '{{%localities}}',
            'provinces_id'
        );

        // add foreign key for table `{{%provinces}}`
        $this->addForeignKey(
            '{{%fk-localities-provinces_id}}',
            '{{%localities}}',
            'provinces_id',
            '{{%provinces}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%localities}}`
        $this->dropForeignKey(
            '{{%fk-localities-provinces_id}}',
            '{{%localities}}'
        );

        // drops index for column `provinces_id`
        $this->dropIndex(
            '{{%idx-localities-provinces_id}}',
            '{{%localities}}'
        );

        // drops table
        $this->dropTable('{{%localities}}');

        return true;
    }
}
