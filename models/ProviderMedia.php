<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider_media".
 *
 * @property int $id
 * @property int $active
 * @property int $providers_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string $data
 *
 * @property Providers $providers
 */
class ProviderMedia extends \yii\db\ActiveRecord
{
    public $path = "../web/uploads/provider/";
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provider_media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active', 'providers_id', 'data'], 'required'],
            [['active', 'providers_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['data'], 'string'],
            [['providers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Providers::className(), 'targetAttribute' => ['providers_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'active' => Yii::t('app', 'Active'),
            'providers_id' => Yii::t('app', 'Providers ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'data' => Yii::t('app', 'Data'),
        ];
    }

    /**
     * Gets query for [[Providers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProviders()
    {
        return $this->hasOne(Providers::className(), ['id' => 'providers_id']);
    }

    public function beforeSave($insert)
    {
        try{
            $this::deleteAll('products_id ='.$this->providers_id);
            $files = glob($this->path .$this->providers_id."/{,.}*", GLOB_BRACE); // get all file names
            foreach($files as $file){ // iterate files
                if(is_file($file))
                    unlink($file); // delete file
            }
            
            /* Estructura a convertir
                $datafilesvideo[
                    [0] => ['type'=>'image','name'=>'URL_IMG'],
                    [1] => ['type'=>'video','name'=>'URL_VIDEO'],
                ]
            */ 
            $datafilesvideo = [];
        
            $total = count($_FILES['files']['name']);
            //recorro imagenes y hago upload de estas
            for ($i=0;$i<$total;$i++) {           
                
                if (!file_exists($this->path .$this->providers_id)) {
                    mkdir($this->path .$this->providers_id, 0777, true);
                }

                $path = $this->path .$this->providers_id."/". basename( $_FILES['files']['name'][$i].rand());                
                move_uploaded_file($_FILES['files']['tmp_name'][$i], $path);

                array_push($datafilesvideo,['type'=>'image','name'=>$path]);

            }

            //recorro videos 
            
            $videos = explode(",", $_POST['videos']);
            foreach ($videos as $video) {
                array_push($datafilesvideo,['type'=>'video','name'=>$video]);
            }

            $this->data = json_encode($datafilesvideo);
            $this->active = 1;
            
            return parent::beforeSave($insert); // TODO: Change the autogenerated stub
        }
        catch(Exeption $e)
        {
            throw new \yii\web\NotFoundHttpException;
        }
    }
}