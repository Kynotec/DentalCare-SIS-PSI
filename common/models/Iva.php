<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ivas".
 *
 * @property int $id
 * @property string|null $percentagem
 * @property string|null $descricao
 * @property int $emvigor
 *
 * @property Produtos[] $produtos
 * @property Servicos[] $servicos
 */
class Iva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ivas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emvigor'], 'integer'],
            [['percentagem'], 'string', 'max' => 2],
            [['descricao'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'percentagem' => 'Percentagem',
            'descricao' => 'Descricao',
            'emvigor' => 'Emvigor',
        ];
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produtos::class, ['iva_id' => 'id']);
    }

    /**
     * Gets query for [[Servicos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServicos()
    {
        return $this->hasMany(Servicos::class, ['iva_id' => 'id']);
    }
}
