<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CursoProger;
use app\models\usuarioGestor;

/**
 * CursoProgerSearch represents the model behind the search form about `app\models\CursoProger`.
 */
class CursoProgerSearch extends CursoProger
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idSituacao', 'idAreaAtuacao', 'idSetor', 'interdepartamental', 'interinstitucional', 'cargaHoraria', 'idTipoProger', 'idProger', 'idGestor'], 'integer'],
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
        //Se usuario logado for admin mostra todos os cursos, se não filtra por gestor do usuario logado
        if(\Yii::$app->user->can('admin')){

        $query = CursoProger::find();

        }else{

        $query = CursoProger::find()->where(['idGestor'=> UsuarioGestor::find()->where(['idUsuario'=>Yii::$app->user->getId()])->one()]);

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
            'cargaHoraria' => $this->cargaHoraria,
            'dataInicio' => $this->dataInicio,
            'dataFim' => $this->dataFim,
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
