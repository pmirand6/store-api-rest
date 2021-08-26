<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%providers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%provider_types}}`
 */
class m200930_124401_add_provider_types_id_column_to_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%providers}}', 'provider_types_id', $this->bigInteger()->notNull());

        // creates index for column `provider_types_id`
        $this->createIndex(
            '{{%idx-providers-provider_types_id}}',
            '{{%providers}}',
            'provider_types_id'
        );

        // add foreign key for table `{{%provider_types}}`
        $this->addForeignKey(
            '{{%fk-providers-provider_types_id}}',
            '{{%providers}}',
            'provider_types_id',
            '{{%provider_types}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%provider_types}}`
        $this->dropForeignKey(
            '{{%fk-providers-provider_types_id}}',
            '{{%providers}}'
        );

        // drops index for column `provider_types_id`
        $this->dropIndex(
            '{{%idx-providers-provider_types_id}}',
            '{{%providers}}'
        );

        $this->dropColumn('{{%providers}}', 'provider_types_id');

        return true;
    }
}
