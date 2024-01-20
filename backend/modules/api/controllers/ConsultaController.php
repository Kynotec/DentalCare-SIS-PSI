<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;
class ConsultaController extends ActiveController
{
    public $modelClass = 'common\models\Consultas';


    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    public function actionCount($data)
    {
        $consultamodel = new $this->modelClass;
        $consulta = $consultamodel::find()
            ->where(['data' => $data])
            ->all();
        return ['count' => count($consulta)];
    }


    public function actionDelporid($consultaid)
    {
        $consultamodel = new $this->modelClass;
        $consulta = $consultamodel::deleteAll(['id' => $consultaid]);
        return $consulta;
    }

    public function actionAlterardata($profileid)
    {
        $nova_data=\Yii::$app->request->post('data');
        $consultamodel = new $this->modelClass;
        $consulta = $consultamodel::findOne(['profile_id' => $profileid]);
        if($consulta) {
            $consulta->data = $nova_data;
            $consulta->save();
            return $this->asJson(
                $consulta
            );
        }
        else {
            throw new \yii\web\NotFoundHttpException("O Id do Utente nao existe!");
        }
    }

}
