<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "consultas".
 *
 * @property int $id
 * @property string|null $descricao
 * @property string|null $data
 * @property string $estado
 * @property int|null $profile_id
 * @property int|null $servico_id
 *
 * @property Diagnosticos[] $diagnosticos
 * @property Profiles $profile
 * @property Servicos $servico
 */
class Consultas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consultas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'string'],
            [['estado'], 'required'],
            [['profile_id', 'servico_id'], 'integer'],
            [['descricao'], 'string', 'max' => 45],
            [['estado'], 'string', 'max' => 30],
            [['servico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicos::class, 'targetAttribute' => ['servico_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descricao',
            'data' => 'Data',
            'estado' => 'Estado',
            'profile_id' => 'Profile ID',
            'servico_id' => 'Servico ID',
        ];
    }

    /**
     * Gets query for [[Diagnosticos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiagnosticos()
    {
        return $this->hasMany(Diagnosticos::class, ['consulta_id' => 'id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::class, ['id' => 'profile_id']);
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
