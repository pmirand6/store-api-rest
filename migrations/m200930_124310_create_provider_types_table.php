<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%provider_types}}`.
 */
class m200930_124310_create_provider_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%provider_types}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'description' => $this->string(100)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%provider_types}}');

        return true;
    }
}
