<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Task;

class Project extends ActiveRecord
{
    public function gettask()
    {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }
}
