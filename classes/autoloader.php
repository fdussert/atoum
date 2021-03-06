<?php

namespace mageekguy\atoum;

class autoloader
{
	protected static $directories = array(__NAMESPACE__ => array(__DIR__));

	public static function register($prepend = false)
	{
		if (spl_autoload_register(array(__CLASS__, 'getClass'), true, $prepend) === false)
		{
			throw new \runtimeException('Unable to register ' . __NAMESPACE__ . ' autoloader');
		}
	}

	public static function addDirectory($namespace, $directory)
	{
		if (isset(self::$directories[$namespace]) === false || in_array($directory, self::$directories[$namespace]) === false)
		{
			self::$directories[$namespace][] = $directory;

			krsort(self::$directories, \SORT_STRING);
		}
	}

	public static function getDirectories()
	{
		return self::$directories;
	}

	public static function getPath($class)
	{
		$path = null;

		foreach (self::$directories as $namespace => $directories)
		{
			if ($class !== $namespace && strpos($class, $namespace) === 0)
			{
				foreach ($directories as $directory)
				{
					$path = $directory . str_replace('\\', DIRECTORY_SEPARATOR, str_replace($namespace, '', $class)) . '.php';

					if (is_file($path) === true)
					{
						return $path;
					}
				}
			}
		}

		return null;
	}

	protected static function getClass($class)
	{
		if (($path = self::getPath($class)) !== null)
		{
			require($path);
		}
	}
}

autoloader::register();

?>
