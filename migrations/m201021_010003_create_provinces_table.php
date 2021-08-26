<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%provinces}}`.
 */
class m201021_010003_create_provinces_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%provinces}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'countries_id' => $this->bigInteger()->notNull(),
            'province' => $this->string(255)->notNull(),
        ]);

        // creates index for column `countries_id`
        $this->createIndex(
            '{{%idx-provinces-countries_id}}',
            '{{%provinces}}',
            'countries_id'
        );

        // add foreign key for table `{{%countries}}`
        $this->addForeignKey(
            '{{%fk-provinces-countries_id}}',
            '{{%provinces}}',
            'countries_id',
            '{{%countries}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%provinces}}`
        $this->dropForeignKey(
            '{{%fk-provinces-countries_id}}',
            '{{%provinces}}'
        );

        // drops index for column `countries_id`
        $this->dropIndex(
            '{{%idx-provinces-countries_id}}',
            '{{%provinces}}'
        );

        $this->dropTable('{{%provinces}}');

        return true;
    }
}
