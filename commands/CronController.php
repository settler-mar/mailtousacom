<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\modules\logs\models\Log;
use app\modules\payment\models\PaymentInclude;
use Yii;
use yii\console\Controller;
use app\modules\order\models\Order;
use app\modules\user\models\User;
use app\modules\orderElement\models\OrderElement;
use app\modules\invoice\models\Invoice;
use keltstr\simplehtmldom\SimpleHTMLDom as SHD;
use app\modules\config\components\DConfig;
use yii\helpers\Console;

/**
 * Команды для оработки кроном.
 *
 */
class CronController extends Controller
{
  /**
   * This command echoes what you have entered as the message.
   */
  public function actionIndex()
  {

    echo '- '.$this->ansiFormat('cron', Console::FG_YELLOW)."\n";

    echo "    ".$this->ansiFormat('cron/refresh', Console::FG_GREEN);
    echo "     Обновить статус посылок (10 штук)\n";

    echo "    ".$this->ansiFormat('cron/exchange', Console::FG_GREEN);
    echo "    Обновить курс cad/usd\n";
  }

  /**
   * Обновить статус посылок (10 штук).
   */
  public function actionRefresh()
  {
    $tot_time=time();
    $data=OrderElement::find()
      ->andWhere(['status'=>[4,5]])
      ->orderBy(['cron_refresh' => SORT_ASC])
      ->limit(Yii::$app->config->get('track_refresh_count'))// берем 10 посылок (надо будет исключить доставленные)
      ->all();

    foreach ($data as $parcel){
      $parcel->cron_refresh = time();          // записываем последнее время обновления
      $company = OrderElement::GetShippingCarrier($parcel->track_number);

      echo PHP_EOL;
      $st_time=time();
      echo $this->ansiFormat(date('d/m/Y G:i:s'), Console::FG_BLUE).'>';
      echo $this->ansiFormat($parcel->track_number, Console::FG_YELLOW).'>';
      if ($company == '') {   // если не определили транспортную компанию
        echo " has unknown shipping company" . PHP_EOL;
        $parcel->save();
        continue;
      }

      echo $company.PHP_EOL;

      $html = SHD::file_get_html('https://trackingshipment.net/' .$company.'/' . $parcel->track_number, null, null, 1, 1); // дружественный сервис просмотра состояний посылок
      $str = $html->find('.output-info p', 0);// берем содержимое первого абзаца у тэга с классом output_info

      if(!$str){//Проверяем нашли ли что то. если нет то берем следующую посылку
        echo $parcel->id . " посылку не нашло".PHP_EOL;
        $parcel->save();
        echo "Время обработки ",$this->ansiFormat(time()-$st_time, Console::FG_BLUE).' секунд'.PHP_EOL;
        continue;
      }
      $str->find('strong', 0)->innertext="";
      $str=trim(strip_tags($str->innertext));
      echo $this->ansiFormat($str, Console::FG_GREEN).PHP_EOL;
      if ((strripos($str, 'eliver') != false)) {   // Если есть включение S-ummary И D-eliver-ed
        echo "Parcel " . $parcel->id . " was delivered".PHP_EOL;
        $parcel->status = 6;
        $parcel->status_dop="";
      } else{
        $parcel->status = 5;
        $parcel->status_dop=$str;
        echo $parcel->id . " not delivered".PHP_EOL;
      }
      $parcel->save();
      echo "Время обработки ",$this->ansiFormat(time()-$st_time, Console::FG_BLUE).' секунд'.PHP_EOL;
    }
    echo PHP_EOL.PHP_EOL."Общее время обработки ",$this->ansiFormat(time()-$tot_time, Console::FG_BLUE).' секунд'.PHP_EOL;
    //   $arr = array ('USPS/9405509699937475900484','USPS/9405509699938333870260','USPS/9407809699939814166833',
    //                  'UPS/1Z4008YY4291160859','UPS/1ZW258314248802240','UPS/1Z2A37W90324146148',
    //                'fedex/786083077470','fedex/786061718512','fedex/786043744820');
  }

  /**
   * Обновить курс cad/usd
   */
  public function actionExchange()
  {
    $html = SHD::file_get_html('https://openexchangerates.org/api/latest.json?app_id=a405ef00381748dd895923fb7008ea34', null, null, 1, 1);
    $arr = json_decode('{'.$html,true);
    $arr2 = $arr['rates'];
    $rate = $arr2['CAD'];

    echo 'Exange rate      : 1[USD]= '.$rate.PHP_EOL;
    $rate = $rate + (($rate*5)/100);
    echo 'Exange rate + 5% : 1[USD]= '.$rate.PHP_EOL;
    $a = new DConfig();
    $a->set('USD_CAD',$rate);
    //Yii::$app->config->set('USD_CAD',$rate);
  }

  public function actionMonthInvoice(){
    $users = User::find()->all();
    foreach ($users as $user){
      var_dump("User ID -".$user->id);
      $this_month_begin = strtotime(date('Y-m-01'));
      $parcels_for_email = [];
      $services_for_email = [];
      $parcels = OrderElement::find()
        ->andWhere(['user_id' => $user->id])
        ->andWhere(['payment_state' => 3])         // работа с пользователями с месячным типом оплаты
        ->andWhere(['status'=> 2])             // берем посылки со статусом 2
        ->andWhere(['>=', 'created_at', $this_month_begin])   // посылки созданные после начала текущего месяца
        ->all();
      if ($parcels){
        foreach ($parcels as $parcel){
          $payment = PaymentInclude::find()
            ->andWhere(['element_id' => $parcel->id])
            ->andWhere(['element_type' => 0])   // тип платежа - за посылку
            ->andWhere(['status' => 0])    //  поиск посылок ожидающих оплаты
            ->one();
          if ($payment){
            $parcels_for_email[] = $parcel->id;
          }
        }
      }else{
        var_dump("No parcels");
      }
      if ($parcels_for_email){
          $inv = new Invoice();
          $inv->create = time();
          $inv->parcels_list = implode(',',$parcels_for_email);
          $inv->services_list = '';
          $inv->detail = json_encode(['cron' => 1]);
          $inv->save();
      } else{
        echo 'empty';
      }
    }
  }

  public function actionClearOrder(){
    $two_month = 60*24*60*60;
    Order::deleteAll('created_at < '.(time()-$two_month));  // удаление Заказов старее двух месяцев
  }

  public function actionMoveToArhiv(){
    $one_month = 30*24*60*60;
    $parcels = OrderElement::find()
      ->andWhere(['created_at' < (time()-$one_month)])  // берем все посылки старше 1 месяца
      ->andWhere(['>=', 'status', 6])
      ->all(); // все посылки старше месяца со статусом 2
    if ($parcels){
      foreach ($parcels as $parcel){
        $old_parcel_log = Log::find()
          ->andWhere(['order_id' => $parcel->id])
          ->andWhere(['description' => 'Change status'])   //  берем запись с изменением статуса
          ->andWhere(['>=', 'status_id', 6])                     // берем статус больше либо равным 2
          ->orderBy('created_at DESC')                // сортируем по убыванию даты
          ->one();                                      // берем первую запись
        if ($old_parcel_log->created_at < (time()-$one_month)) {
          $model = OrderElement::findOne($parcel->id);
          $model->archive = 1;
        }
      }
    }
  }
}
