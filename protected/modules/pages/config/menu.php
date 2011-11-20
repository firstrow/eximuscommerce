<?php
/**
 * Admin menu items for pages module
 */
return array(
    'cms'=>array(
        'items'=>array(
            array(
                'label'=>'Страницы', 
                'url'=>array('/admin/pages'), 
                'position'=>3
            ),
            array(
                'label'=>'Категории', 
                'url'=>array('/admin/pages/category'), 
                'position'=>4
            ),
        ),
    ),
);