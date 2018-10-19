<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Админ-Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<?php
$script = <<<JS
var resId = 0;
$.ajax({
        url: 'index.php?r=admin/get-last',
        data: {id:0},
        type: 'GET',
        success: function(res)
        {
            var t = JSON.parse(res);
            resId = parseInt(t[0].id);
            
        },
        error: function()
        {
            alert('Error!');
        }
    });
setInterval(function(){
    var id = 0;
        $.get('http://test.ru/web/index.php?r=admin/get-last',{id:resId},function(data){
            var t = JSON.parse(data);
            if(resId < parseInt(t[0].id))
            {
            alert('Новый заказ от Пользователя На продукт - ' + t[0].name + '. Обновите страницу!');
            resId = parseInt(t[0].id);
            }
        });
    },1000);
JS;
$this->registerJs($script); 
?>