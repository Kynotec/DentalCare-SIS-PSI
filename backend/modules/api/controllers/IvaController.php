<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;
class IvaController extends ActiveController
{
    public $modelClass = 'common\models\Iva';

    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    public function actionAlterarestadoiva($id)
    {
        $novo_estado = \Yii::$app->request->post('emvigor');
        $ivamodel = new $this->modelClass;
        $iva = $ivamodel::findOne(['id' => $id]);

        $estadosPermitidos = ['9', '10'];

        if ($iva) {
            if (in_array($novo_estado, $estadosPermitidos)) {
                $iva->emvigor = $novo_estado;
                $iva->save();
                return $this->asJson($iva);
            } else {
                return $this->asJson(['error' => 'O estado deve ser "9" ou "10"']);
            }
        } else {
            throw new \yii\web\NotFoundHttpException("O id do Iva não existe!");
        }
    }

}
