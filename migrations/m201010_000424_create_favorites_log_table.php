<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorites_log}}`.
 */
class m201010_000424_create_favorites_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorites_log}}', [
            'log_id' => $this->bigPrimaryKey()->notNull(),
            'id' => $this->bigInteger()->notNull(),
            'clients_id' => $this->bigInteger()->notNull(),
            'products_id' => $this->bigInteger()->notNull(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `id`
        $this->createIndex(
            '{{%idx-favorites_log-id}}',
            '{{%favorites_log}}',
            'id'
        );

        // add foreign key for table `{{%favorites}}`
        $this->addForeignKey(
            '{{%fk-favorites_log-id}}',
            '{{%favorites_log}}',
            'id',
            '{{%favorites}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%favorites_log}}`
        // $this->dropForeignKey(
        //     '{{%fk-favorites_log-id}}',
        //     '{{%favorites_log}}'
        // );

        // // drops index for column `favorites_log_id`
        // $this->dropIndex(
        //     '{{%idx-favorites_log-id}}',
        //     '{{%favorites}}'
        // );

        $this->dropTable('{{%favorites_log}}');

        return true;
    }
}
