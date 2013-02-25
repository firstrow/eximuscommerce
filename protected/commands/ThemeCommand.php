<?php

/**
 * Command to create themes from default files.
 * Usage: ./yiic theme themeName
 * - will create theme theme under /themes directory
 */
class ThemeCommand extends CConsoleCommand
{
	public function run($args=null)
	{
		$theme=$args[0];
		$themePath=realpath(dirname(__FILE__).'/../../themes').DIRECTORY_SEPARATOR.$theme;

		if(!file_exists($themePath))
		{
			mkdir($themePath);
			mkdir($themePath.'/views');
		}

		// Find all modules views and copy to theme directory
		$files=glob(realpath(dirname(__FILE__).'/../').'/modules/*', GLOB_ONLYDIR);
		foreach($files as $file)
		{
			$parts=explode('/', $file);
			$module=end($parts);
			$moduleThemePath=$themePath.'/views/'.$module;

			$moduleViews=glob($file.'/views/*',GLOB_ONLYDIR);
			foreach($moduleViews as $viewsDirPath)
			{
				$parts=explode('/', $viewsDirPath);
				if(end($parts)!='admin')
				{
					if(!file_exists($moduleThemePath))
						mkdir($moduleThemePath);
					CFileHelper::copyDirectory($viewsDirPath, $moduleThemePath.'/'.end($parts));
				}
			}
		}
	}
}
