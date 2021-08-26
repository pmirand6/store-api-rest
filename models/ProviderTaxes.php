<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider_taxes".
 *
 * @property int $id
 * @property string $cuit
 * @property string $number
 * @property string $qualification
 * @property string $qualification_notes
 * @property int $active
 * @property int $providers_id
 *
 * @property Providers $providers
 */
class ProviderTaxes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider_taxes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuit', 'active', 'providers_id'], 'required'],
            [['active'], 'boolean'],
            [['providers_id'], 'integer'],
            [['cuit'], 'string', 'max' => 20],
            [['number'], 'string', 'max' => 30],
            [['qualification'], 'string', 'max' => 255],
            [['qualification_notes'], 'string'],
            [['providers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Providers::className(), 'targetAttribute' => ['providers_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cuit' => 'Cuit',
            'number' => 'Number',
            'qualification' => 'Qualification',
            'qualification_notes' => 'Qualification Notes',
            'active' => 'Active',
            'providers_id' => 'Providers ID',
        ];
    }

    /**
     * Gets query for [[Providers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(Providers::className(), ['id' => 'providers_id']);
    }
}
