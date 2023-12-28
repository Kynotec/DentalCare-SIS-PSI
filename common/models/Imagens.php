<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "imagens".
 *
 * @property int $id
 * @property string $filename
 * @property int $produto_id
 * @property int $servico_id
 * @property int $diagnostico_id
 *
 * @property Diagnosticos $diagnostico
 * @property Produtos $produto
 * @property Servicos $servico
 */
class Imagens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filename', 'produto_id', 'servico_id', 'diagnostico_id'], 'required'],
            [['produto_id', 'servico_id', 'diagnostico_id'], 'integer'],
            [['filename'], 'string', 'max' => 2000],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produtos::class, 'targetAttribute' => ['produto_id' => 'id']],
            [['servico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicos::class, 'targetAttribute' => ['servico_id' => 'id']],
            [['diagnostico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Diagnosticos::class, 'targetAttribute' => ['diagnostico_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'produto_id' => 'Produto ID',
            'servico_id' => 'Servico ID',
            'diagnostico_id' => 'Diagnostico ID',
        ];
    }

    /**
     * Gets query for [[Diagnostico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiagnostico()
    {
        return $this->hasOne(Diagnosticos::class, ['id' => 'diagnostico_id']);
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produtos::class, ['id' => 'produto_id']);
    }

    /**
     * Gets query for [[Servico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServico()
    {
        return $this->hasOne(Servicos::class, ['id' => 'servico_id']);
    }
}
