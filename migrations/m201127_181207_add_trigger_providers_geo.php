<?php

use yii\db\Migration;

/**
 * Class m201127_181207_add_trigger_providers_geo
 */
class m201127_181207_add_trigger_providers_geo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sqlTriggerBeforeInsert = <<< SQL
            CREATE DEFINER = CURRENT_USER TRIGGER `providers_generate_geo_BEFORE_INSERT` BEFORE INSERT ON `providers` FOR EACH ROW
            BEGIN
                SET NEW.geo = ST_GeomFromText(concat("point(", NEW.latitude," ",NEW.longitude,")"),4326);
            END
        SQL;

        $this->execute($sqlTriggerBeforeInsert);

        $sqlTriggerBeforeUpdate = <<< SQL
            CREATE DEFINER = CURRENT_USER TRIGGER `providers_generate_geo_BEFORE_UPDATE` BEFORE UPDATE ON `providers` FOR EACH ROW
            BEGIN
                SET NEW.geo = ST_GeomFromText(concat("point(", NEW.latitude," ",NEW.longitude,")"),4326);
            END
        SQL;

        $this->execute($sqlTriggerBeforeUpdate);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201127_181207_add_trigger_providers_geo cannot be reverted.\n";
        $this->execute('DROP TRIGGER /*!50032 IF EXISTS */ `providers_generate_geo_BEFORE_INSERT`');
        $this->execute('DROP TRIGGER /*!50032 IF EXISTS */ `providers_generate_geo_BEFORE_UPDATE`');

        return true;
    }

}
