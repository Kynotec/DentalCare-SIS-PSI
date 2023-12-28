<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinhos".
 *
 * @property int $id
 * @property string|null $data
 * @property int|null $stock
 * @property float|null $valortotal
 *
 * @property LinhaCarrinhos[] $linhaCarrinhos
 */
class Carrinhos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinhos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'safe'],
            [['stock'], 'integer'],
            [['valortotal'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'stock' => 'Stock',
            'valortotal' => 'Valortotal',
        ];
    }

    /**
     * Gets query for [[LinhaCarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaCarrinhos()
    {
        return $this->hasMany(LinhaCarrinhos::class, ['carrinho_id' => 'id']);
    }
}
