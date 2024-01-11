<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;
class ServicoController extends ActiveController
{
    public $modelClass = 'common\models\Servicos';

    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    public function actionServicospeladescricao($descricao)
    {
        $servicomodel = new $this->modelClass;
        $servico = $servicomodel::find()
            ->where(['descricao' => $descricao])
            ->all();
        return $servico;
    }

}
