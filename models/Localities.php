<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "localities".
 *
 * @property int $id
 * @property int $provinces_id
 * @property string $locality
 *
 * @property Provinces $provinces
 * @property Providers[] $providers
 * @property string $code [varchar(28)]
 * @property bool $active [tinyint(1)]
 */
class Localities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'localities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['provinces_id', 'locality', 'code'], 'required'],
            [['provinces_id', 'active'], 'integer'],
            [['locality'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 28],
            [['provinces_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::className(), 'targetAttribute' => ['provinces_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provinces_id' => 'Provinces ID',
            'locality' => 'Locality',
            'code' => 'Code',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[Provinces]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Provinces::className(), ['id' => 'provinces_id']);
    }

    /**
     * Gets query for [[Providers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProviders()
    {
        return $this->hasMany(Providers::className(), ['localities_id' => 'id']);
    }

    /**
     * @return String
     */
    public static function getLocalityName($idLocality){
        try{
            return self::find()->where($idLocality)->one();
        }catch(Exeption $e){
            throw $e->getMessage();
        }
    }

    public function extraFields()
    {
        return [ 'province', 'providers' ];
    }
}
