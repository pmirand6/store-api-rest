<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%provider_taxes}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%providers_id}}`
 */
class m200930_125120_add_providers_id_column_to_provider_taxes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%provider_taxes}}', 'providers_id', $this->bigInteger()->notNull());

        // creates index for column `providers_id`
        $this->createIndex(
            '{{%idx-provider_taxes-providers_id}}',
            '{{%provider_taxes}}',
            'providers_id'
        );

        // add foreign key for table `{{%providers_id}}`
        $this->addForeignKey(
            '{{%fk-provider_taxes-providers_id}}',
            '{{%provider_taxes}}',
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
        // drops foreign key for table `{{%providers_id}}`
        $this->dropForeignKey(
            '{{%fk-provider_taxes-providers_id}}',
            '{{%provider_taxes}}'
        );

        // drops index for column `providers_id`
        $this->dropIndex(
            '{{%idx-provider_taxes-providers_id}}',
            '{{%provider_taxes}}'
        );

        $this->dropColumn('{{%provider_taxes}}', 'providers_id');

        return true;
    }
}
