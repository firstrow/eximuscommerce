<?php

class BaseModel extends CActiveRecord {

    public function init()
    {
        SModelEventManager::attachEvents($this);
    }

}