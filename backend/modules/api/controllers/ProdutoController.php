<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produtos';


    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    public function actionAlterarpreco($nome)
    {
        $novo_preco=\Yii::$app->request->post('precounitario');
        $produtomodel = new $this->modelClass;
        $produto = $produtomodel::findOne(['nome' => $nome]);
        if($produto) {
            $produto->precounitario = $novo_preco;
            $produto->save();
            return $this->asJson(
                $produto
            );
        }
        else {
            throw new \yii\web\NotFoundHttpException("O nome do produto não existe!");
        }
    }

}
