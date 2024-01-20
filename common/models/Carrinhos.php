<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinhos".
 *
 * @property int $id
 * @property string|null $data
 * @property float|null $valortotal
 * @property int $user_id
 *
 * @property Linha_carrinhos[] $linhaCarrinhos
 * @property User $user
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
            [['valortotal'], 'number'],
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'valortotal' => 'Valortotal',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[LinhaCarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaCarrinhos()
    {
        return $this->hasMany(Linha_carrinhos::class, ['carrinho_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    public function calcularTotalCarrinho()
    {
        $totalCarrinho = 0;

        foreach ($this->linhaCarrinhos as $linhaCarrinho) {
            $totalCarrinho += $linhaCarrinho->calcularTotal();
        }

        $this->valortotal = $totalCarrinho;
        $this->save();

        return $totalCarrinho;
    }


}
