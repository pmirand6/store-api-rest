<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%provider_deliveries}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%providers}}`
 */
class m200930_123012_create_provider_deliveries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%provider_deliveries}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'time_from' => $this->time()->notNull(),
            'time_to' => $this->time()->notNull(),
            'day' => "ENUM('Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom') NOT NULL",
            'providers_id' => $this->bigInteger()->notNull()
        ]);

        // creates index for column `providers_id`
        $this->createIndex(
            '{{%idx-provider_deliveries-providers_id}}',
            '{{%provider_deliveries}}',
            'providers_id'
        );

        // add foreign key for table `{{%providers}}`
        $this->addForeignKey(
            '{{%fk-provider_deliveries-providers_id}}',
            '{{%provider_deliveries}}',
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
            '{{%fk-provider_deliveries-providers_id}}',
            '{{%provider_deliveries}}'
        );

        // drops index for column `providers_id`
        $this->dropIndex(
            '{{%idx-provider_deliveries-providers_id}}',
            '{{%provider_deliveries}}'
        );

        $this->dropTable('{{%provider_deliveries}}');

        return true;
    }
}
