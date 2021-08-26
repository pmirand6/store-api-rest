<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider_images".
 *
 * @property int $id
 * @property string $image
 * @property int $providers_id
 *
 * @property Providers $providers
 */
class ProviderImages extends \yii\db\ActiveRecord
{
    public $path = "../web/uploads/provider/";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['providers_id'], 'required'],
            [['image'], 'string'],
            [['providers_id'], 'integer'],
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
            'image' => 'Image',
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

    public function beforeSave($insert)
    {
        try{
            if(isset($_FILES['image'])){
                if (!file_exists($this->path .$this->providers_id)) {
                    mkdir($this->path .$this->providers_id, 0777, true);
                }

                $path = $this->path .$this->providers_id."/". basename( $_FILES['image']['name'].rand());                
                move_uploaded_file($_FILES['image']['tmp_name'], $path);

                $this->image = $path;
            }

            return parent::beforeSave($insert); // TODO: Change the autogenerated stub
        }
        catch(Exeption $e)
        {
            throw new \yii\web\NotFoundHttpException;
        }
    }
}