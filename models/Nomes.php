<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Nomes;

class Nomes extends ActiveRecord
{
	public function actionNomes(){
		$nomes = Nomes::find()->orderBy('nome')->all;
		echo '<pre>';
		print_t($nomes);
	}

}



