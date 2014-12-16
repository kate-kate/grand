<?php
namespace app\models\decorators;

use app\models\Participant;
use yii\helpers\Html;

/**
 * Description of PaymentUpdate
 *
 * @author mlapko
 */
class PaymentUpdate extends BaseActivityDecorator
{
    
    public function render($view)
    {
        $p = Participant::findOne($this->attributes['player_id']);
        return Html::encode($p->name) . 
            ' правит правит платёж c "' . Html::tag('span', Html::encode($this->changeAttributes['sum']), ['class' => 'looser']) . 
            '" на "' . Html::tag('span', Html::encode($this->attributes['sum']), ['class' => 'winner']) . '"';
    }
}
