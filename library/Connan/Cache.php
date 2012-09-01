<?php
	
	class Connan_Cache extends Connan_Util_Singleton
	{
		/**
		 * timeout
		 * duration of the cache
		 *
		 * @protected
		 */
		protected $timeout = 60;
		
		/**
		 * path
		 * path to save the cache
		 *
		 * @protected
		 */
		protected $path = null;
		
		/**
		 * ext
		 * cache extension
		 *
		 * @protected
		 */
		protected $ext = 'txt';
		
		/**
		 * constructor
		 * @param string $path (optional) : cache path
		 * @public
		 */
		public function __construct($path = CACHE_PATH){
			$this->path($path);
		}
		
		/**
		 * timeout()
		 * Return Thor_Cache::$timeout
		 * if $timeout isn't null, change Thor_Cache::$timeout to $timeout
		 *
		 * @param int $timeout (optional) : cache duration
		 * @public
		 * @return int Thor_Cache::$timeout
		 */
		public function timeout($timeout = null)
		{
			if(!is_null($timeout))
				$this->timeout = (int) $timeout;
			return $this->timeout;
		}
		
		/**
		 * path()
		 * Return Thor_Cache::$path
		 * if $path isn't null, change Thor_Cache::$path to $path
		 *
		 * @param string $path (optional) : path to save the cache
		 * @public
		 * @return string Thor_Cache::$path
		 */
		public function path($path = null)
		{
			if(!is_null($path))
				$this->path = (string) $path;
			return $this->path;
		}
		
		/**
		 * ext()
		 * Return Thor_Cache::$ext
		 * if $ext isn't null, change Thor_Cache::$ext to $ext
		 *
		 * @param string $ext (optional) : cache extension
		 * @public
		 * @return string Thor_Cache::$ext
		 */
		public function ext($ext = null)
		{
			if(!is_null($ext))
				$this->ext = (string) $ext;
			return $this->ext;
		}
		
		/**
		 * getCacheFile()
		 * Return cache file name
		 *
		 * @param string $key : key of cache
		 * @public
		 * @return string cache file name
		 */
		protected function getCacheFile($key)
		{
			return sprintf('%s%s%s.%s', $this->path, DS, md5($key), $this->ext);
		}
		
		/**
		 * isCache()
		 * Return if has cache with $key as name
		 *
		 * @param string $key : key of cache
		 * @public
		 * @return bool is cached
		 */
		public function isCache($key)
		{
			$filename = $this->getCacheFile($key);
			if(file_exists($filename))
			{
				if(time() < (filemtime($filename) + (60 * $this->timeout)))
					return true;
			}
			return false;
		}
		
		/**
		 * read()
		 * Read a cache
		 *
		 * @param string $key : key of cache
		 * @public
		 * @return string content of cache
		 */
		public function read($key)
		{
			$filename = $this->getCacheFile($key);
			if(file_exists($filename))
			{
				if(!$result = file_get_contents($filename))
					ConnanException::raise(array(
						'code'  => 80,
						'message' => 'read file error',
						'package' => 'cache'
					));
				return $result;
			}
		}
		
		/**
		 * write()
		 * Write in cache
		 *
		 * @param string $key : key of cache
		 * @public
		 * @return bool wrote?
		 */
		public function write($key, $content)
		{
			if(file_put_contents($this->getCacheFile($key), $content))
				return true;
			else
				return false;
		}
		
		/**
		 * delete()
		 * Delete cache
		 *
		 * @param string $key : key of cache
		 * @public
		 * @return bool
		 */
		public function delete($key)
		{
			if(file_exists($this->getCacheFile($key)))
				return unlink($this->getCacheFile($key));
			return true;
		}
		
	}