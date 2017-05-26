<?php

namespace app\modules\importAccount\models;

use Yii;

/**
 * This is the model class for table "import_parcel_account".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $type
 * @property string $name
 * @property string $token
 * @property integer $last_update
 */
class ImportParcelAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_parcel_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id', 'type', 'last_update','created'], 'integer'],
            [['name', 'token'], 'string', 'max' => 1000],
        ];
    }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'type' => 'Provider',
            'name' => 'External username',
            'token' => 'Token',
            'last_update' => 'Last Update',
            'create' => 'Last Update',
        ];
    }

    public function beforeValidate()
    {
      if($this->isNewRecord){
        $this->created=time();
        $this->client_id=Yii::$app->user->id;
      };
      return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }



}