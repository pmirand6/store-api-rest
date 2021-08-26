<?php

use yii\db\Migration;

/**
 * Class m201021_010152_add_localities_id_providers_table
 */
class m201021_010152_add_localities_id_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%providers}}', 'localities_id', $this->bigInteger()->notNull());

        // creates index for column `localities_id`
        $this->createIndex(
            '{{%idx-providers-localities_id}}',
            '{{%providers}}',
            'localities_id'
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
        // drops foreign key for table `{{%localities}}`
        $this->dropForeignKey(
            '{{%fk-providers-localities_id}}',
            '{{%providers}}'
        );

        // drops index for column `localities_id`
        $this->dropIndex(
            '{{%idx-providers-localities_id}}',
            '{{%providers}}'
        );

        $this->dropColumn('{{%providers}}', 'localities_id');

        return true;
    }
}
