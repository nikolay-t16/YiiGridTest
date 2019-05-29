<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 28.05.2019
 * Time: 13:04
 */

namespace app\models;

use maper\Category;
use maper\Product;
use maper\CaProduct;
use yii\base\Model;
use light\yii2\XmlParser;

/**
 * Class Catalog
 * @package app\models
 */
class Catalog extends Model {
	/**
	 * @var string
	 */
	protected static $categoriesPath = "..\assets\categories.xml";
	/**
	 * @var string
	 */
	protected static $productsPath = "..\assets\products.xml";

	public static $filterFields = ['id', 'categoryName','price','hidden'];

	protected static function checkFilter($filter, $item) {

	}

	protected static function makeProduct($it, $categories) {
		$prod = new Product();
		$prod->id = $it["id"];
		$prod->categoryId = $it["categoryId"];
		$prod->categoryName = $categories[$prod->categoryId];
		$prod->price = $it["price"];
		$prod->hidden = $it["hidden"] == 1;
		return $prod;
	}

	public static function GetCatalog($request) {
		$filter = $request->get('CatalogFilter');
		$categories = self::GetCategories();
		$parser = new XmlParser();
		$res = $parser->parse(file_get_contents(self::$productsPath), "xml");
		$products = [];
		foreach ($res["item"] as $it) {
			if (!$filter ||
				(!$filter['id'] || $filter['id'] == $it['id']) &&
				(!$filter['price'] || $filter['price'] == $it['price']) &&
				(!$filter['hidden'] || $filter['hidden'] == $it['hidden']) &&
				(!$filter['categoryName'] || $filter['categoryName'] == $it['categoryId'])
			) {
				$products[$it['id']] = self::makeProduct($it, $categories);
			}

		}
		return [$products, $categories];
	}

	public static function GetCategories() {
		if (empty(self::$products)) {
			$parser = new XmlParser();
			$res = $parser->parse(file_get_contents(self::$categoriesPath), "xml");
			$categoties = [];
			foreach ($res["item"] as $it) {
				$categoties[$it["id"]] = $it["name"];
			}
		}
		return $categoties;
	}
}
