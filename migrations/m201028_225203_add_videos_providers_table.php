<?php

use yii\db\Migration;

/**
 * Class m201028_225203_add_videos_providers_table
 */
class m201028_225203_add_videos_providers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%providers}}', 'videos', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201028_225203_add_videos_providers_table cannot be reverted.\n";

        $this->dropColumn('{{%providers}}', 'videos');

        return true;
    }
}
