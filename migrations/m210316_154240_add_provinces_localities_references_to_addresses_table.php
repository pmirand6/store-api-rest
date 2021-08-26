<?php

use yii\db\Migration;

/**
 * Class m210316_154240_add_provinces_localities_references_to_addresses_table
 */
class m210316_154240_add_provinces_localities_references_to_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%addresses}}', 'provinces_id', $this->bigInteger()->notNull()->defaultValue(1));
        $this->addColumn('{{%addresses}}', 'localities_id', $this->bigInteger()->notNull()->defaultValue(1));

        // creates index for column `provinces_id`
        $this->createIndex(
            '{{%idx-addresses-provinces_id}}',
            '{{%addresses}}',
            'provinces_id'
        );

        // creates index for column `localities_id`
        $this->createIndex(
            '{{%idx-addresses-localities_id}}',
            '{{%addresses}}',
            'localities_id'
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

        // add foreign key for table `{{%localities}}`
        $this->addForeignKey(
            '{{%fk-addresses-localities_id}}',
            '{{%addresses}}',
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
            '{{%fk-addresses-provinces_id}}',
            '{{%addresses}}'
        );

        // drops foreign key for table `{{%localities}}`
        $this->dropForeignKey(
            '{{%fk-addresses-localities_id}}',
            '{{%addresses}}'
        );

        // drops index for column `provinces_id`
        $this->dropIndex(
            '{{%idx-addresses-provinces_id}}',
            '{{%addresses}}'
        );

        // drops index for column `localities_id`
        $this->dropIndex(
            '{{%idx-addresses-localities_id}}',
            '{{%addresses}}'
        );

        $this->dropColumn('{{%addresses}}', 'provinces_id');

        $this->dropColumn('{{%addresses}}', 'localities_id');

        return true;
    }
}
