<?php

use yii\db\Migration;

/**
 * Class m210130_164645_add_image_preference_to_clients_table
 */
class m210130_164645_add_image_preference_to_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%clients}}', 'image_preference', "ENUM('avatar', 'picture')");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210130_164645_add_image_preference_to_clients_table cannot be reverted.\n";

        $this->dropColumn('{{%clients}}', 'image_preference');

        return false;
    }
}
