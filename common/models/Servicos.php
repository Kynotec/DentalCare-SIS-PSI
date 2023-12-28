<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servicos".
 *
 * @property int $id
 * @property string|null $referencia
 * @property string|null $descricao
 * @property float|null $preco
 * @property int|null $ativo
 * @property int|null $iva_id
 *
 * @property Consultas[] $consultas
 * @property Imagens[] $imagens
 * @property Iva $iva
 * @property Linha_Faturas[] $linhaFaturas
 */
class Servicos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preco'], 'number'],
            [['ativo', 'iva_id'], 'integer'],
            [['referencia'], 'string', 'max' => 45],
            [['descricao'], 'string', 'max' => 100],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::class, 'targetAttribute' => ['iva_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referencia' => 'Referencia',
            'descricao' => 'Descricao',
            'preco' => 'Preco',
            'ativo' => 'Ativo',
            'iva_id' => 'Iva ID',
        ];
    }

    /**
     * Gets query for [[Consultas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsultas()
    {
        return $this->hasMany(Consultas::class, ['servico_id' => 'id']);
    }

    /**
     * Gets query for [[Imagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagens()
    {
        return $this->hasMany(Imagens::class, ['servico_id' => 'id']);
    }

    /**
     * Gets query for [[Iva]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIva()
    {
        return $this->hasOne(Iva::class, ['id' => 'iva_id']);
    }

    /**
     * Gets query for [[LinhaFaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaFaturas()
    {
        return $this->hasMany(Linha_Faturas::class, ['servico_id' => 'id']);
    }
}
