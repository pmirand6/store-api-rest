<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%provider_taxes}}`.
 */
class m200930_114413_create_provider_taxes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%provider_taxes}}', [
            'id' => $this->primaryKey()->notNull(),
            'cuit' => $this->string(20)->notNull(),
            'number' => $this->string(30)->notNull(),
            'qualification' => $this->string(30)->notNull()->defaultValue(0),
            'qualification_notes' => $this->string(100)->notNull()->defaultValue(''),
            'active' => $this->boolean()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%provider_taxes}}');

        return true;
    }
}
