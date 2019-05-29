<?php
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<div class="site-index">



	<?= GridView::widget([
		'dataProvider' => $prodDataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			'id',
			[
				'attribute'=>'categoryName',
				'label' => 'Раздел',
				'filter' => $categories
			],
			[
				'attribute'=>'price',
				'label' => 'Цена'
			],
			[
				'attribute'=>'hidden',
				'label' => 'Доступен',
				'content'=>function($data){
					return $data->hidden ? 'Да':'Нет';
				},
				'format' => 'raw',
				/**
				 * Переопределяем отображение фильтра.
				 * Задаем выпадающий список с заданными значениями вместо поля для ввода
				 */
				'filter' => [
					0 => 'Нет',
					1 => 'Да',
				],
			]
		],
	]); ?>
</div>
