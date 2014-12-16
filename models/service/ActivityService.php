<?php
namespace app\models\service;

use app\models\Activity;
use app\models\Match;
use app\models\Pair;
use app\models\Payment;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use yii\db\AfterSaveEvent;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;

class ActivityService extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Event::on(Match::className(), BaseActiveRecord::EVENT_AFTER_UPDATE, [$this, 'create']);
        Event::on(Pair::className(), BaseActiveRecord::EVENT_AFTER_UPDATE, [$this, 'create']);
//        Event::on(Payment::className(), BaseActiveRecord::EVENT_AFTER_UPDATE, [$this, 'create']);
        Event::on(Payment::className(), BaseActiveRecord::EVENT_AFTER_INSERT, [$this, 'create']);
//        Event::on(Pair::className(), BaseActiveRecord::EVENT_AFTER_UPDATE, [$this, 'create']);
    }
    
    /**
     * 
     * @param AfterSaveEvent $event
     */
    public function create($event)
    {
        if ($event->sender instanceof Payment && $event->sender->status === Payment::PAYMENT_STATUS_CREDITS) {
            return;
        }
        $class = $event->sender->formName();
        $data = [
            'type' => $class . strtr($event->name, ['after' => '']),
            'data' => [
                'attrs' => $event->sender->getAttributes(),
                'changed' => $event->changedAttributes,
            ]
        ];
        $this->insert($data);
    }
    
    private function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['data'] = Json::encode($data['data']);
        return Activity::getDb()->createCommand()->insert(Activity::tableName(), $data)->execute();
    }
}

