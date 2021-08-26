<?php

use yii\db\Migration;

/**
 * Class m210106_013215_update_addresses_table
 */
class m210106_013215_update_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%addresses}}', 'street');
        $this->dropColumn('{{%addresses}}', 'number');
        $this->dropColumn('{{%addresses}}', 'floor');
        $this->dropColumn('{{%addresses}}', 'apartment');
        $this->dropColumn('{{%addresses}}', 'zip_code');

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

        $this->dropColumn('{{%addresses}}', 'countries_id');
        $this->dropColumn('{{%addresses}}', 'provinces_id');
        $this->dropColumn('{{%addresses}}', 'localities_id');

        $this->addColumn('{{%addresses}}', 'postal_code', $this->string(255));
        $this->addColumn('{{%addresses}}', 'locality', $this->string(255));
        $this->addColumn('{{%addresses}}', 'address', $this->string(255));
        $this->addColumn('{{%addresses}}', 'street_number', $this->string(255));
        $this->addColumn('{{%addresses}}', 'city', $this->string(255));
        $this->addColumn('{{%addresses}}', 'province', $this->string(255));
        $this->addColumn('{{%addresses}}', 'country', $this->string(255));
        $this->addColumn('{{%addresses}}', 'formatted_address', $this->string(255));
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210106_013215_update_addresses_table cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210106_013215_update_addresses_table cannot be reverted.\n";

        return false;
    }
    */
}
