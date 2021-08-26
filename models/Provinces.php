<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provinces".
 *
 * @property int $id
 * @property int $countries_id
 * @property string $province
 * @property string $code
 * @property int $active
 *
 * @property Localities[] $localities
 * @property Countries $countries
 */
class Provinces extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provinces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['countries_id', 'province', 'code'], 'required'],
            [['countries_id'], 'integer'],
            [['province'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 28],
            [['active'], 'boolean'],
            [['countries_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['countries_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'countries_id' => 'Countries ID',
            'province' => 'Province',
            'code' => 'Code',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[Localities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalities()
    {
        return $this->hasMany(Localities::className(), ['provinces_id' => 'id']);
    }

    /**
     * Gets query for [[Countries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'countries_id']);
    }

    /**
     * @return String
     */
    public static function getProvinceName($idProvince){
        try{
            return self::find()->where($idProvince)->one();
        }catch(Exeption $e){
            throw $e->getMessage();
        }
    }

    public function extraFields()
    {
        return [ 'country', 'localities' ];
    }
}
