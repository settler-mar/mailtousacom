<?php

namespace app\modules\user\components;

use app\modules\user\models\forms\LoginForm;
use app\modules\user\models\User;
use app\modules\address\models\Address;
use yii\base\Widget;
use yii\helpers\Url;
use Yii;
use yii\web\Controller;

class UserWidget extends Widget
{
    public function run()
    {
        $isLogin=false;
        if(Yii::$app->user->isGuest) {
            $model = new LoginForm();
            if(Yii::$app->request->post()) {
                $model->load(Yii::$app->request->post());
                $isLogin = $model->login();
            }
            if(!$isLogin) {
                return $this->render('loginWidget', [
                    'model' => $model
                ]);
            }else{
              $this->view->context->redirect(['/']);
              Yii::$app->end();
            }
        }

        $user_data=Yii::$app->user->identity->toArray();
        $haveOneAddress = Address::find()->where('user_id = :id', [':id' => $user_data['id']])->one();
        if(strlen($user_data['photo'])<10){
            $user_data['photo']='/img/avatar.jpg';
        }
        if ($haveOneAddress) {
            return $this->render('onlineWidget', $user_data);
        }
    }

}