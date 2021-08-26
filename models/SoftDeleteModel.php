<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "search_logs".
 *
 * @property int $id
 * @property string|null $query
 * @property int|null $users_id
 *
 * @property Users $users
 */
class SoftDeleteModel extends \yii\db\ActiveRecord
{
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if(!$insert) {
            $this->updated_at = date('Y-m-d H:m:s');
        }

        return parent::beforeSave($insert);
    }
}

?>