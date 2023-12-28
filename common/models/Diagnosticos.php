<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "diagnosticos".
 *
 * @property int $id
 * @property string|null $descricao
 * @property string|null $data
 * @property int $profile_id
 * @property int $consulta_id
 *
 * @property Consultas $consulta
 * @property Imagens[] $imagens
 * @property Profiles $profile
 */
class Diagnosticos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diagnosticos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'safe'],
            [['profile_id', 'consulta_id'], 'required'],
            [['profile_id', 'consulta_id'], 'integer'],
            [['descricao'], 'string', 'max' => 45],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::class, 'targetAttribute' => ['profile_id' => 'id']],
            [['consulta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultas::class, 'targetAttribute' => ['consulta_id' => 'id']],
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
            'profile_id' => 'Profile ID',
            'consulta_id' => 'Consulta ID',
        ];
    }

    /**
     * Gets query for [[Consulta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsulta()
    {
        return $this->hasOne(Consultas::class, ['id' => 'consulta_id']);
    }

    /**
     * Gets query for [[Imagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagens()
    {
        return $this->hasMany(Imagens::class, ['diagnostico_id' => 'id']);
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
}
