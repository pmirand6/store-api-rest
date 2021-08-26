<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%provider_images}}`.
 */
class m201003_173520_create_provider_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%provider_images}}', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'image' => $this->text()->notNull(),
            'providers_id' => $this->bigInteger()->notNull()
        ]);

        // creates index for column `providers_id`
        $this->createIndex(
            '{{%idx-provider_images-providers_id}}',
            '{{%provider_images}}',
            'providers_id'
        );

        // add foreign key for table `{{%providers}}`
        $this->addForeignKey(
            '{{%fk-provider_images-providers_id}}',
            '{{%provider_images}}',
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
        // drops foreign key for table `{{%providers}}`
        $this->dropForeignKey(
            '{{%fk-provider_images-providers_id}}',
            '{{%provider_images}}'
        );

        // drops index for column `providers_id`
        $this->dropIndex(
            '{{%idx-provider_images-providers_id}}',
            '{{%provider_images}}'
        );

        $this->dropTable('{{%provider_images}}');

        return true;
    }
}
