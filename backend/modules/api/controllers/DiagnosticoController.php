<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;
class DiagnosticoController extends ActiveController
{
    public $modelClass = 'common\models\Diagnosticos';


    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }


    public function actionDatadiagnostico($profile_id)
    {
        $diagnosticomodel = new $this->modelClass;

        $diagnostico = $diagnosticomodel::find()
            ->select(['data'])
            ->where(['profile_id' => $profile_id])
            ->all();
        return $diagnostico;
    }

    public function actionConsultautente($profile_id)
    {
        $diagnosticomodel = new $this->modelClass;

        $diagnostico = $diagnosticomodel::find()
            ->select(['diagnosticos.profile_id', 'consultas.descricao', 'consultas.data', 'consultas.estado'])
            ->innerJoinWith('consulta')
            ->where(['diagnosticos.profile_id' => $profile_id])
            ->asArray()
            ->all();

        return $diagnostico;
    }

}
