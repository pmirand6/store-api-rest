<?php

use yii\db\Migration;

/**
 * Class m210316_163021_add_provinces_localities_references_to_providers_table
 */
class m210316_163021_add_provinces_localities_references_to_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%providers}}', 'provinces_id', $this->bigInteger()->notNull()->defaultValue(1));
        $this->addColumn('{{%providers}}', 'localities_id', $this->bigInteger()->notNull()->defaultValue(1));

        // creates index for column `provinces_id`
        $this->createIndex(
            '{{%idx-providers-provinces_id}}',
            '{{%providers}}',
            'provinces_id'
        );

        // creates index for column `localities_id`
        $this->createIndex(
            '{{%idx-providers-localities_id}}',
            '{{%providers}}',
            'localities_id'
        );

        // add foreign key for table `{{%provinces}}`
        $this->addForeignKey(
            '{{%fk-providers-provinces_id}}',
            '{{%providers}}',
            'provinces_id',
            '{{%provinces}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%localities}}`
        $this->addForeignKey(
            '{{%fk-providers-localities_id}}',
            '{{%providers}}',
            'localities_id',
            '{{%localities}}',
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
            '{{%fk-providers-provinces_id}}',
            '{{%providers}}'
        );

        // drops foreign key for table `{{%localities}}`
        $this->dropForeignKey(
            '{{%fk-providers-localities_id}}',
            '{{%providers}}'
        );

        // drops index for column `provinces_id`
        $this->dropIndex(
            '{{%idx-providers-provinces_id}}',
            '{{%providers}}'
        );

        // drops index for column `localities_id`
        $this->dropIndex(
            '{{%idx-providers-localities_id}}',
            '{{%providers}}'
        );

        $this->dropColumn('{{%providers}}', 'provinces_id');

        $this->dropColumn('{{%providers}}', 'localities_id');

        return true;
    }
}
