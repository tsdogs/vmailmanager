<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Domain;

/**
 * DomainSearch represents the model behind the search form of `app\models\Domain`.
 */
class DomainSearch extends Domain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'aliases', 'mailboxes', 'quota', 'active', 'created_at', 'updated_at'], 'integer'],
            [['domain', 'destination', 'description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Domain::find();
        
        if (!Yii::$app->user->identity->isMaster) {
            $query->joinWith('adminDomains')->where(['admin_domain.admin_id'=>Yii::$app->user->id]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'domain.id' => $this->id,
            'domain.aliases' => $this->aliases,
            'domain.mailboxes' => $this->mailboxes,
            'domain.quota' => $this->quota,
            'domain.active' => $this->active,
            'domain.created_at' => $this->created_at,
            'domain.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'domain.domain', $this->domain])
            ->andFilterWhere(['like', 'domain.destination', $this->destination])
            ->andFilterWhere(['like', 'domain.description', $this->description]);

        return $dataProvider;
    }
}
