<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователь-Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Сделать заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
$scrpt = <<<JS
var resId = 0;
$.ajax({
        url: 'index.php?r=user/get-last',
        data: {id:0},
        type: 'GET',
        success: function(res)
        {
            var t = JSON.parse(res);
            resId = t[0].date;
            
            
        },
        error: function()
        {
            alert('Error!');
        }
    });
setInterval(function(){
    var id = 0;
        $.get('http://test.ru/web/index.php?r=user/get-last',{id:resId},function(data){
            var t = JSON.parse(data);
            if(resId != t[0].date)
            {
            alert('Заказ изменен от Админа На продукт - ' + t[0].name + '. Обновите страницу!');
            resId = t[0].date;
            }
        });
    },1000);
JS;
$this->registerJs($scrpt); 
?>