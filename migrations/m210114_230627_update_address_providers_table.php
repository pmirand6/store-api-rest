<?php

use yii\db\Migration;

/**
 * Class m210114_230627_update_address_providers_table
 */
class m210114_230627_update_address_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
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

        $this->addColumn('{{%providers}}', 'postal_code', $this->string(255));
        $this->addColumn('{{%providers}}', 'locality', $this->string(255));
        $this->addColumn('{{%providers}}', 'address', $this->string(255));
        $this->addColumn('{{%providers}}', 'street_number', $this->string(255));
        $this->addColumn('{{%providers}}', 'city', $this->string(255));
        $this->addColumn('{{%providers}}', 'province', $this->string(255));
        $this->addColumn('{{%providers}}', 'country', $this->string(255));
        $this->addColumn('{{%providers}}', 'formatted_address', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210114_230627_update_address_providers_table cannot be reverted.\n";

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

        $this->dropColumn('{{%providers}}', 'postal_code');
        $this->dropColumn('{{%providers}}', 'locality');
        $this->dropColumn('{{%providers}}', 'address');
        $this->dropColumn('{{%providers}}', 'street_number');
        $this->dropColumn('{{%providers}}', 'city');
        $this->dropColumn('{{%providers}}', 'province');
        $this->dropColumn('{{%providers}}', 'country');
        $this->dropColumn('{{%providers}}', 'formatted_address');

        return true;
    }
}
