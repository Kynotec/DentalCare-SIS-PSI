<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class LinhafaturaController extends ActiveController
{
    public $modelClass = 'common\models\Linha_faturas';

    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }
    //Serve para filtrar atraves do token as faturas do perfil autenticado
    public function actionLinhafaturadados($fatura_id)
    {
        $model = new $this->modelClass;

        $linhafaturas = $model::find()
            ->select([
                'linha_faturas.id',
                'linha_faturas.quantidade',
                'linha_faturas.valorunitario',
                'linha_faturas.valoriva',
                'linha_faturas.valortotal',
                'linha_faturas.fatura_id',
                'linha_faturas.produto_id',
                'linha_faturas.servico_id',
                '(SELECT nome FROM produtos WHERE id = linha_faturas.produto_id) AS produtonome',
                '(SELECT nome FROM servicos WHERE id = linha_faturas.servico_id) AS serviconome'
            ])
            ->where(['fatura_id'=>$fatura_id])
            ->asArray()
            ->all();
        return $linhafaturas;
    }

}