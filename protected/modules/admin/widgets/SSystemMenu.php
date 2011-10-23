<?php

/**
 * Renders admin top menu
 */
class SSystemMenu extends CWidget {

    public function run()
    {
        /**
         * TODO: Search in all modules config/adminMenu.php and build menus
         */
        $items = array(
            'users'=>array(
                'label'=>'Система',
                'items'=>array(
                    array('label'=>'Пользователи', 'url'=>array('/admin/users/default'), 'position'=>1),
                ),
            ),
        );

        $items = CMap::mergeArray($items, $this->findMenuFiles());
        
        $this->processSorting($items);
        $this->widget('application.extensions.mbmenu.MbMenu', array('items'=>$items));
    }

    /**
     * Sort menu items by position key.
     *
     * @param  $items Menu items
     */
    protected function processSorting(&$items)
    {
        uasort($items, "SSystemMenu::sortByPosition");
        foreach ($items as $key => $item)
        {
            if (isset($item['items']))
                $this->processSorting($items[$key]['items']);
        }
    }

    /**
     * Find and load module menu files.
     * TODO: Load only menu files from installed modules and cache result. 
     */
    protected function findMenuFiles()
    {
        $result = array();
        $files = glob(Yii::getPathOfAlias('application.modules.*') . '/*/config/menu.php');

        foreach($files as $file)
            $result = CMap::mergeArray($result, require($file));

        return $result;
    }
    
    /**
     *  Sort an array
     *
     * @static
     * @param  $a array
     * @param  $b array
     * @return int
     */
    public static function sortByPosition($a, $b)
    {
        if (isset($a['position']) && isset($b['position']))
        {
            if ((int)$a['position'] == (int)$b['position'])
                return 0;
            return ((int)$a['position'] > (int)$b['position']) ? 1 : -1;
        }

        return 1;
    }

}