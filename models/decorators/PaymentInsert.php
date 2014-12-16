<?php
namespace app\models\decorators;

use app\models\Participant;
use yii\helpers\Html;

/**
 * Description of PaymentInsert
 *
 * @author mlapko
 */
class PaymentInsert extends BaseActivityDecorator
{
    
    public function render($view)
    {
        $p = Participant::findOne($this->attributes['player_id']);
        return Html::encode($p->name) . ' пополняет баланс на ' . Html::tag('span', $this->attributes['sum'], ['class' => 'winner']); 
    }
}
