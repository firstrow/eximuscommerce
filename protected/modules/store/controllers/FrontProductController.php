<?php

/**
 * Display products
 */
class FrontProductController extends Controller
{

    /**
     * Display product
     * @param $url product url
     */
    public function actionView($url)
    {
        $model = StoreProduct::model()
            ->withUrl($url)
            ->find();

        var_dump($model);
    }
}
