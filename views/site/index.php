<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Project;
?>

<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2><?= Yii::t('app', 'Projects') ?></h2>
                <hr>
                <div class="row">
                    <?php $form = ActiveForm::begin(); ?>
                        <div class="col-xs-6">
                            <?= $form->field($model, 'dropdownIndex')->dropDownList(
                                    ArrayHelper::map(Project::find()->asArray()->all(), 'id', 'name'),
                                )->label(false)
                            ?>   
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('app', 'Select'), ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>        
                </div>        
                <div id="treeview" class=""></div>
            </div>
            <div class="col-lg-4">
            <h2><?= Yii::t('app', 'Project details') ?></h2>
            <hr>
                <h3><?= Yii::t('app', 'Progress') ?> - <?= $progressBarPercentage ?>%</h3>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?= $progressBarPercentage ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $progressBarPercentage ?>%">
                    <span class="sr-only"><?= $progressBarPercentage ?>% Complete</span>
                </div>
            </div>
            </div>
            <div class="col-lg-4">
                <h2><?= Yii::t('app', 'App info') ?></h2>
                <hr>
                <p><?= Yii::t('app', 'This app will load data of projects and its belonging tasks and reports and construct a treeview menu as well as display the completeness of the project based on its reports.') ?></p>
            </div>
        </div>

    </div>
</div>

<script>
    var treeviewData = <?= $treeviewData ?>;
</script>