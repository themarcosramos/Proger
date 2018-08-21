<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GruposUsuario;
use yii\data\ArrayDataProvider;

/**
 * GruposUsuarioSearch represents the model behind the search form about `app\models\GruposUsuario`.
 */
class GruposUsuarioSearch extends GruposUsuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['descricao'], 'safe'],
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
        //$query = GruposUsuario::findAll();

        /*$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);*/

        $dataProvider = new ArrayDataProvider([
            'allModels' => GruposUsuario::findAll(),
            'sort' => [
                'attributes' => ['name', 'descricao'],
            ],
            'key' => 'name',
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        /*$query->andFilterWhere([
            'name' => $this->name,
            'descricao' => $this->descricao,
        ]);

        $query->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'name', $this->name]);*/

        return $dataProvider;
    }
}
