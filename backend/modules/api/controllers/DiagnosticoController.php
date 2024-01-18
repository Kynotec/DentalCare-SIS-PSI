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
    //Serve para filtrar atraves do token os diagnósticos do perfil autenticado
    public function actionGetPerfilDiagnostico()
    {
        $model = new $this->modelClass;

        $diagnosticos = $model::find()
            ->select([
                'diagnosticos.id',
                'diagnosticos.descricao',
                'diagnosticos.data',
                'diagnosticos.hora',

                'diagnosticos.consulta_id',
                'diagnosticos.profile_id',
                '(SELECT data FROM consultas WHERE id = diagnosticos.consulta_id) AS consultadata',
                '(SELECT hora FROM consultas WHERE id = diagnosticos.consulta_id) AS consultahora'
            ])
            ->where(['diagnosticos.profile_id' => Yii::$app->params['id']])
            ->asArray()
            ->all();

        return $diagnosticos;
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
