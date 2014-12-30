<?php

namespace app\models\search;

use app\models\Participant;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Match;
use yii\db\Query;

/**
 * MatchSearch represents the model behind the search form about `app\models\Match`.
 */
class MatchSearch extends Match
{

    public $players = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pair_id_1', 'pair_id_2', 'winner_id', 'date', 'part_winner_id_1', 'part_winner_id_2'], 'integer'],
            [['status', 'players'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Match::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

//        $query->with('pairOne', 'pairTwo');
//        $query->addSelect('COUNT(pair_one_matches_played) + COUNT(pair_two_matches_played) as matches_index');
//        $query->orderBy('matches_index');

        if (!($this->load($params) && $this->validate())) {
            $this->filterPlayers($query, array_keys($this->getPlayersList()));
            return $dataProvider;
        }
        if ($this->players) {
            $this->filterPlayers($query, $this->players);
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'pair_id_1' => $this->pair_id_1,
            'pair_id_2' => $this->pair_id_2,
            'winner_id' => $this->winner_id,
            'date' => $this->date,
            'part_winner_id_1' => $this->part_winner_id_1,
            'part_winner_id_2' => $this->part_winner_id_2,
        ]);

        $query->andFilterWhere(['status' => $this->status]);

        return $dataProvider;
    }

    public function getPlayersList($withBalance = true)
    {
        $players = $this->getPlayersQuery($withBalance);
        $players = $players->orderBy(['name' => SORT_ASC])->all();
        $list = array();
        foreach ($players as $player) {
            $list[$player->id] = $player->name;
        }
        return $list;
    }

    public function getPlayersQuery($withBalance = true)
    {
        $query = Participant::find()->where(['status' => 'active']);
        if ($withBalance) {
            $query->andWhere('balance>=:b', [':b' => Match::MATCH_BANK]);
        }
        return $query;
    }

    public function filterPlayers($query, $players)
    {
        $allPlayers = array_keys($this->getPlayersList(false));
        $cantPlay = array_diff($allPlayers, $players);
        $pairs = (new Query())->select('id')->from('pair');
        if (count($players) > 3) {
            $pairs->andFilterWhere(['not in', 'participant_id_1', $cantPlay])
                  ->andFilterWhere(['not in', 'participant_id_2', $cantPlay]);
            $query->andFilterWhere(['in', 'pair_id_1', $pairs])->andFilterWhere(['in', 'pair_id_2', $pairs]);
        } else {
            $pairs->andFilterWhere(['or', ['in', 'participant_id_1', $players], ['in', 'participant_id_2', $players]]);
            $query->andFilterWhere(['or', ['in', 'pair_id_1', $pairs], ['in', 'pair_id_2', $pairs]]);
        }   
    }
}
