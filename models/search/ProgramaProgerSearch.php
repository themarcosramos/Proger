<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProgramaProger;
use app\models\usuarioGestor;

/**
 * ProgramaProgerSearch represents the model behind the search form about `app\models\ProgramaProger`.
 */
class ProgramaProgerSearch extends ProgramaProger
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idSituacao', 'idAreaAtuacao', 'idSetor', 'interdepartamental', 'interinstitucional', 'idGestor'], 'integer'],
            [['nome', 'descricao', 'dataInicio', 'dataFim', 'observacoes'], 'safe'],
            
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
        //Se usuario logado for admin mostra todos os programa, se não filtra por gestor do usuario logado
        if(\Yii::$app->user->can('admin')){

            $query = ProgramaProger::find();
    
            }else{
    
            $query = ProgramaProger::find()->where(['idGestor'=> UsuarioGestor::find()->where(['idUsuario'=>Yii::$app->user->getId()])->one()]);
            
            }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'nome' => SORT_ASC,                    
                ]
            ],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'idSituacao' => $this->idSituacao,
            'idAreaAtuacao' => $this->idAreaAtuacao,
            'idSetor' => $this->idSetor,
            'interdepartamental' => $this->interdepartamental,
            'interinstitucional' => $this->interinstitucional,
            'dataInicio' => $this->dataInicio,
            'dataFim' => $this->dataFim,
            'idGestor' => $this->idGestor,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes]);

        return $dataProvider;
    }
}
