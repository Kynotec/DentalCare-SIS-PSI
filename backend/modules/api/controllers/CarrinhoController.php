<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii;

class CarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\Carrinhos';

    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        //QUERY PARAM
        if (\Yii::$app->params['id'] == 2){
            if($action === "delete"){
                throw  new yii\web\ForbiddenHttpException("Acesso Proibido!");
            }
        }
    }

    public function actionCount()
    {
        $carrinhosmodel = new $this->modelClass;
        $carrinho = $carrinhosmodel::find()->all();
        return ['count' => count($carrinho)];
    }

}