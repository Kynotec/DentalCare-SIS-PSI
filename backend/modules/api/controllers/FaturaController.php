<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;



class FaturaController extends ActiveController
{
    public $modelClass = 'common\models\Faturas';


    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    public function actionAlterarestado($profile_id)
    {
        $novo_estado = \Yii::$app->request->post('estado');
        $faturamodel = new $this->modelClass;
        $fatura = $faturamodel::findOne(['profile_id' => $profile_id]);

        $estadosPermitidos = ['emitido', 'pendente', 'concluido'];

        if ($fatura) {
            if (in_array($novo_estado, $estadosPermitidos)) {
                $fatura->estado = $novo_estado;
                $fatura->save();
                return $this->asJson($fatura);
            } else {
                return $this->asJson(['error' => 'O estado deve ser "emitido", "pendente" ou "concluido"']);
            }
        } else {
            throw new \yii\web\NotFoundHttpException("O id do Utente não existe!");
        }
    }

}
