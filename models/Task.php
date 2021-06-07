<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Report;

class Task extends ActiveRecord
{
    public function getreport()
    {
        return $this->hasMany(Report::class, ['task_id' => 'id']);
    }
}
