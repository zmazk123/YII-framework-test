<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\db\Query;
use app\models\TreeviewData;
use app\models\Project;
use app\models\Report;
use app\models\Task;
use app\models\ProjectSelectForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new ProjectSelectForm();
        $query = new Query;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $project = Project::find()
            ->where(['id' => $model->dropdownIndex])
            ->one();

            $treeviewJsonData = $this->constructTreeDataForProject($project);

            $progressBarPercentage = round($this->calculateProjectCompleteness($project));

            return $this->render('index', ['treeviewData' => $treeviewJsonData, 'model' => $model, 'progressBarPercentage' => $progressBarPercentage]);
        } else {           
            $project = Project::find()
            ->one();

            $treeviewJsonData = $this->constructTreeDataForProject($project);

            $progressBarPercentage = round($this->calculateProjectCompleteness($project));

            return $this->render('index', ['treeviewData' => $treeviewJsonData, 'model' => $model, 'progressBarPercentage' => $progressBarPercentage]);
        }
    }

    private function constructTreeDataForProject($project) {
        $tasks = Task::find()
        ->joinWith('report')
        ->where(['project_id' => $project->id])
        ->all();

        $treeviewNodes = [];
        foreach($tasks as $task) {
            $node = new TreeviewData();
            $node->text = $task->name;

            $reports = $task->report;  

            $counter = 0;   
            $children = [];           
            foreach($reports as $report) {
                $child = new TreeviewData();
                $child->text = $report->name;
                $child->tags = [$report->percent_done.'%'];

                $counter++;
                $children = array_merge($children, array($child));
            }

            if($counter != 0) {
                $node->nodes = $children;
            }
                
            $treeviewNodes = array_merge($treeviewNodes, array($node));
        }
            
        $treeviewJsonData = json_encode($treeviewNodes);
        return $treeviewJsonData;
    }

    private function calculateProjectCompleteness($project) {
        $tasks = Task::find()
        ->joinWith('report')
        ->where(['project_id' => $project->id])
        ->all();

        $projectCompleteness = 0;
        $counter = 0;
        foreach($tasks as $task) {
            $reports = $task->report;  

            $taskCompleteness = 0;
            $counter2 = 0;          
            foreach($reports as $report) {

                $taskCompleteness += $report->percent_done;
                $counter2++;
            }
            if($counter2 == 0) {
                $projectCompleteness += 0;
            }
            else {
                $projectCompleteness += $taskCompleteness/$counter2;
            }
            
            $counter++;
        }
       
        if($counter == 0) {
            return 0;
        }
        else {
            return $projectCompleteness/$counter;
        }
    }
}
