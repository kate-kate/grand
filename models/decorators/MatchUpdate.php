<?php
namespace app\models\decorators;

use app\models\Match;
use yii\helpers\Html;

/**
 * Description of MatchUpdate
 *
 * @author mlapko
 */
class MatchUpdate extends BaseActivityDecorator
{
    
    public function render($view)
    {
        $match = Match::findOne($this->attributes['id']);
        $score = $match->winner_id == $match->pair_id_1 ? 
            $match->winner_score . ' : ' . $match->looser_score : 
            $match->looser_score . ' : ' . $match->winner_score;
        return 'Cыгран матч ' . 
            Html::tag('span', $match->pairOne->getFullName(), ['class' => $match->pair_id_1 == $match->winner_id ? 'winner' : 'looser']) . 
            ' ' . $score . ' ' .
            Html::tag('span', $match->pairTwo->getFullName(), ['class' => $match->pair_id_2 == $match->winner_id ? 'winner' : 'looser']);
    }
}
