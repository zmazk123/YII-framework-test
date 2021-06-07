<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ProjectSelectForm extends Model
{
    public $dropdownIndex;

    public function rules()
    {
        return [
            [['dropdownIndex'], 'required'],
        ];
    }
}
