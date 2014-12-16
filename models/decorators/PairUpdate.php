<?php
namespace app\models\decorators;

use app\models\Pair;
use yii\helpers\Html;

/**
 * Description of PairUpdate
 *
 * @author mlapko
 */
class PairUpdate extends BaseActivityDecorator
{
    
    public function render($view)
    {
        $pair = Pair::findOne($this->attributes['id']);
        return 'Пара ' . Html::encode('"' . $pair->getAlias() . '"') . 
            ' меняет название c "' . Html::tag('span', Html::encode($this->changeAttributes['name']), ['class' => 'looser']) . 
            '" на "' . Html::tag('span', Html::encode($this->attributes['name']), ['class' => 'winner']) . '"';
    }
}
