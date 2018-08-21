<?php

namespace app\controllers;

use Yii;
use yii\base\Controller;
use app\models\Nomes;

class ExerciciosController extends Controller
{
	public function actionNomes(){
		$nomes = Nomes::find()->orderBy('nome')->all();
		echo '<pre>';
		print_r($nomes);
	}
}