<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EventoProger;
use app\models\usuarioGestor;

/**
 * EventoPorger represents the model behind the search form about `app\models\EventoProger`.
 */
class EventoPorger extends EventoProger
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idTipoEvento', 'idAreaAtuacao', 'numeroParticipantes', 'idTipoProger', 'idProger', 'idGestor'], 'integer'],
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
        //Se usuario logado for admin mostra todos os evento, se não filtra por gestor do usuario logado
        if(\Yii::$app->user->can('admin')){

            $query = EventoProger::find();
    
            }else{
    
            $query = EventoProger::find()->where(['idGestor'=> UsuarioGestor::find()->where(['idUsuario'=>Yii::$app->user->getId()])->one()]);
            
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
            'id' => $this->id,
            'idTipoEvento' => $this->idTipoEvento,
            'idAreaAtuacao' => $this->idAreaAtuacao,
            'dataInicio' => $this->dataInicio,
            'dataFim' => $this->dataFim,
            'numeroParticipantes' => $this->numeroParticipantes,
            'idTipoProger' => $this->idTipoProger,
            'idProger' => $this->idProger,
            'idGestor' => $this->idGestor,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes]);

        return $dataProvider;
    }
}
