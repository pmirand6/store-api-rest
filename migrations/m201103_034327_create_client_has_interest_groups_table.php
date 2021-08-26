<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_has_interest_groups}}`.
 */
class m201103_034327_create_client_has_interest_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_has_interest_groups}}', [
            'id' => $this->primaryKey(),
            'clients_id' => $this->bigInteger()->notNull(),
            'product_types_id' => $this->bigInteger()->notNull(),
        ]);

        // creates index for column `clients_id`
        $this->createIndex(
            '{{%idx-client_has_interest_groups-clients_id}}',
            '{{%client_has_interest_groups}}',
            'clients_id'
        );

        // add foreign key for table `{{%clients}}`
        $this->addForeignKey(
            '{{%fk-client_has_interest_groups-clients_id}}',
            '{{%client_has_interest_groups}}',
            'clients_id',
            '{{%clients}}',
            'id',
            'CASCADE'
        );

        // creates index for column `product_types_id`
        $this->createIndex(
            '{{%idx-client_has_interest_groups-product_types_id}}',
            '{{%client_has_interest_groups}}',
            'product_types_id'
        );

        // add foreign key for table `{{%product_types}}`
        $this->addForeignKey(
            '{{%fk-client_has_interest_groups-product_types_id}}',
            '{{%client_has_interest_groups}}',
            'product_types_id',
            '{{%product_types}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%clients}}`
        $this->dropForeignKey(
            '{{%fk-client_has_interest_groups-clients_id}}',
            '{{%client_has_interest_groups}}'
        );

        // drops index for column `clients_id`
        $this->dropIndex(
            '{{%idx-client_has_interest_groups-clients_id}}',
            '{{%client_has_interest_groups}}'
        );
        // drops foreign key for table `{{%product_types}}`
        $this->dropForeignKey(
            '{{%fk-client_has_interest_groups-product_types_id}}',
            '{{%client_has_interest_groups}}'
        );

        // drops index for column `product_types_id`
        $this->dropIndex(
            '{{%idx-client_has_interest_groups-product_types_id}}',
            '{{%client_has_interest_groups}}'
        );

        $this->dropTable('{{%client_has_interest_groups}}');

        return true;
    }
}
