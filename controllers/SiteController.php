<?php

namespace app\controllers;

use app\models\CatalogFilter;
use Yii;
use yii\web\Controller;
use app\models\Catalog;
use yii\data\ArrayDataProvider;

class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$request = Yii::$app->request;
		$searchModel = new CatalogFilter($request);
    	list ($products, $categories) = Catalog::GetCatalog($request);
		$provider = new ArrayDataProvider([
			'allModels' => $products,
			'sort' => [
				'attributes' => ['id', 'categoryName','price','hidden'],
			],
		]);
		return $this->render('index',
			[
				"prodDataProvider" => $provider,
				"searchModel" => $searchModel,
				"categories" => $categories,
			]);
    }

}
