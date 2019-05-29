<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 28.05.2019
 * Time: 17:08
 */

namespace app\models;


use yii\base\Model;
use yii\data\ArrayDataProvider;

class CatalogFilter extends Model {
	public $id;
	public $categoryId;
	public $categoryName;
	public $price;
	public $hidden;

	public function filter(array $data)
	{
		foreach($data AS $rowIndex => $row) {
			foreach($this->filters AS $key => $value) {
				// unset if filter is set, but doesn't match
				if(array_key_exists($key, $row) AND !empty($value)) {
					if(stripos($row[$key], $value) === false)
						unset($data[$rowIndex]);
				}
			}
		}
		return $data;
	}

	public static function search($params) {
		$products = Catalog::GetProducts();
		$provider = new ArrayDataProvider([
			'allModels' => [],
			'sort' => [
				'attributes' => ['id', 'categoryName', 'price', 'hidden'],
			],
		]);
		return $provider;
	}

	public function rules()
	{
		//echo "<pre>"; print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));die;
		return [
			[['id', 'categoryName', 'price', 'hidden'], 'safe'],
		];
	}
	public function attributeLabels() {
		return [
			'id' => 'Id',
			'categoryName' => 'Категория',
			'price' => 'Цена',
			'hidden' => 'Доступно'
		];
	}


}
