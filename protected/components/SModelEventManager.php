<?php

/**
 * Implements `global` application events.
 * Helps to attach events to any BaseModel class.
 *
 * Usage:
 * 1. Create events class in module config directory and name it like {module}ModuleEvents.php
 * 2. Events class must have method named `getEvents` that describes events.
 *
 *        public function getEvents()
 *        {
 *            return array(
 *                  array('Page', 'onAfterSave', array($this, 'pageAfterSave')),
 *            );
 *        }
 */
class SModelEventManager
{

    /**
     * @var boolean is class initialized
     */
    public static $initialized = false;

    /**
     * Stores all events as array.
     * array(
     *      className=>array(eventName, handler)
     * )
     * @var array
     */
    public static $events = array();

    /**
     * Initialize class.
     * Search all events in modules and cache them.
     * TODO: Cache events in production mode
     * @static
     */
    public static function init()
    {
        self::$initialized = true;

        foreach(SystemModules::getEnabled() as $module)
        {
            $className = ucfirst($module->name).'ModuleEvents';
            $path = Yii::getPathOfAlias('application.modules.'.$module->name.'.config.'.$className).'.php';

            if(file_exists($path))
                self::loadEventsFile($path, $className);
        }
    }

    /**
     * Attach events to object
     * @static
     * @param CActiveRecord $object
     */
    public static function attachEvents(CActiveRecord $object)
    {
        if(self::$initialized === false)
            self::init();

        if(isset(self::$events[get_class($object)]))
        {
            $events = self::$events[get_class($object)];
            foreach($events as $e)
                $object->attachEventHandler($e[0], $e[1]);
        }
    }

    /**
     * Load and process events class
     * @static
     * @param $filePath path to event class
     * @param $className
     */
    public static function loadEventsFile($filePath, $className)
    {
        require $filePath;
        $eventsClass = new $className;
        $events = $eventsClass->getEvents();
        if(empty($events))
            return;

        foreach($events as $event)
            self::cacheEvent($event[0], $event[1], $event[2]);
    }

    /**
     * Cache all found event for current request.
     * @static
     * @param $class model class name
     * @param $event event name
     * @param $handler event handler array(object, method)
     */
    public static function cacheEvent($class, $event, $handler)
    {
        self::$events[$class][] = array($event, $handler);
    }

}
