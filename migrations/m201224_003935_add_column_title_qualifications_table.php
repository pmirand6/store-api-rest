<?php

use yii\db\Migration;

/**
 * Class m201224_003935_add_column_title_qualifications_table
 */
class m201224_003935_add_column_title_qualifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%qualifications}}', 'title', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201224_003935_add_column_title_qualifications_table cannot be reverted.\n";

        $this->dropColumn('{{%qualifications}}', 'title');

        return true;
    }
}
