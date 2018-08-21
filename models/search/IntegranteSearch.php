<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Integrante as IntegranteModel;

/**
 * Integrante represents the model behind the search form about `app\models\Integrante`.
 */
class IntegranteSearch extends IntegranteModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idTipoVinculo', 'idTipoFuncao', 'idInstituicao', 'idSetor', 'idCurso', 'idPessoa', 'ativo', 'cargaHoraria', 'idTipoProger', 'idProger'], 'integer'],
            [['dataInicio', 'dataFim', 'matricula'], 'safe'],
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
        $query = IntegranteModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10 ],
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
            'idTipoVinculo' => $this->idTipoVinculo,
            'idTipoFuncao' => $this->idTipoFuncao,
            'idInstituicao' => $this->idInstituicao,
            'idSetor' => $this->idSetor,
            'idCurso' => $this->idCurso,
            'idPessoa' => $this->idPessoa,
            'dataInicio' => $this->dataInicio,
            'dataFim' => $this->dataFim,
            'ativo' => $this->ativo,
            'cargaHoraria' => $this->cargaHoraria,
            'idTipoProger' => $this->idTipoProger,
            'idProger' => $this->idProger,
        ]);

        $query->andFilterWhere(['like', 'matricula', $this->matricula]);

        return $dataProvider;
    }
}
