<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%addresses}}`.
 */
class m201024_043858_create_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%addresses}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'street' => $this->string(128)->notNull(),
            'number' => $this->string(8)->notNull(),
            'floor' => $this->string(60)->notNull(),
            'apartment' => $this->string(60)->notNull(),
            'zip_code' => $this->string(60)->notNull(),
            'countries_id' => $this->bigInteger()->notNull(),
            'provinces_id' => $this->bigInteger()->notNull(),
            'localities_id' => $this->bigInteger()->notNull(),
            'geo' => 'POINT NOT NULL SRID 4326',
            'latitude' => $this->double()->notNull(),
            'longitude' => $this->double()->notNull(),
            'clients_id' => $this->bigInteger()->notNull(),
            'updated_at' => $this->timestamp(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `countries_id`
        $this->createIndex(
            '{{%idx-addresses-countries_id}}',
            '{{%addresses}}',
            'countries_id'
        );

        // add foreign key for table `{{%countries}}`
        $this->addForeignKey(
            '{{%fk-addresses-countries_id}}',
            '{{%addresses}}',
            'countries_id',
            '{{%countries}}',
            'id',
            'CASCADE'
        );

        // creates index for column `provinces_id`
        $this->createIndex(
            '{{%idx-addresses-provinces_id}}',
            '{{%addresses}}',
            'provinces_id'
        );

        // add foreign key for table `{{%provinces}}`
        $this->addForeignKey(
            '{{%fk-addresses-provinces_id}}',
            '{{%addresses}}',
            'provinces_id',
            '{{%provinces}}',
            'id',
            'CASCADE'
        );

        // creates index for column `localities_id`
        $this->createIndex(
            '{{%idx-addresses-localities_id}}',
            '{{%addresses}}',
            'localities_id'
        );

        // add foreign key for table `{{%localities}}`
        $this->addForeignKey(
            '{{%fk-addresses-localities_id}}',
            '{{%addresses}}',
            'localities_id',
            '{{%localities}}',
            'id',
            'CASCADE'
        );

        // creates index for column `clients_id`
        $this->createIndex(
            '{{%idx-addresses-clients_id}}',
            '{{%addresses}}',
            'clients_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-addresses-clients_id}}',
            '{{%addresses}}',
            'clients_id',
            '{{%clients}}',
            'id',
            'CASCADE'
        );

        $this->execute('CREATE SPATIAL INDEX idx_geo_index on '.'{{%addresses}}(geo);');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%clients}}`
        $this->dropForeignKey(
            '{{%fk-addresses-clients_id}}',
            '{{%addresses}}'
        );

        // drops index for column `clients_id`
        $this->dropIndex(
            '{{%idx-addresses-clients_id}}',
            '{{%addresses}}'
        );

        // drops foreign key for table `{{%countries}}`
        $this->dropForeignKey(
            '{{%fk-addresses-countries_id}}',
            '{{%addresses}}'
        );

        // drops index for column `countries_id`
        $this->dropIndex(
            '{{%idx-addresses-countries_id}}',
            '{{%addresses}}'
        );

        // drops foreign key for table `{{%provinces}}`
        $this->dropForeignKey(
            '{{%fk-addresses-provinces_id}}',
            '{{%addresses}}'
        );

        // drops index for column `provinces_id`
        $this->dropIndex(
            '{{%idx-addresses-provinces_id}}',
            '{{%addresses}}'
        );

        // drops foreign key for table `{{%localities}}`
        $this->dropForeignKey(
            '{{%fk-addresses-localities_id}}',
            '{{%addresses}}'
        );

        // drops index for column `localities_id`
        $this->dropIndex(
            '{{%idx-addresses-localities_id}}',
            '{{%addresses}}'
        );

        $this->dropTable('{{%addresses}}');

        return true;
    }
}
