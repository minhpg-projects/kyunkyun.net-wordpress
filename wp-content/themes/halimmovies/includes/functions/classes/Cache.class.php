<?php

/**
 * Class cache result for api
 * @author HaiLong
 */
class Cache
{
	public $timeCache;
	public $folderCache;

	function __construct() // 10800 = 3 * 60 * 60 => 3 hour
	{
		$this->folderCache = HALIM_CACHE_PART;
		$this->timeCache = 3600;
	}

	/**
	 * read cache
	 * @time   2017-04-29T10:05:58+0700
	 * @author HaiLong
	 * @param  string $name
	 * @return string
	 */
	public function readCache($name){
		$name = md5(md5($name));
		$result = '';
		$createFolderCache = $this->createFolderCache($name);
		$file = $this->folderCache.'/'.$createFolderCache.'/'.$name.'.txt';
		if(file_exists($file)){
			if($this->timeCache != ''){
				if($this->timeCache > (time() - filemtime($file))){
					$result = file_get_contents($file);
				}
			}else{
				$result = file_get_contents($file);
			}
		}
		return $result;
	}

	/**
	 * get cache
	 * @time   2019-02-20T10:10:33+0700
	 * @author HaLim
	 * @return array
	 */
	public function getCache(){
	    $result = array();
	    $getDirContents = $this->getDirContents($this->folderCache);
	    $i = 0;
	    if($getDirContents){
	        foreach ($getDirContents as $key => $value) {
	            if(strpos($value, '.txt')){
	            	$result[] = array(
	            		'file'	=> $value
	            	);
	            }
	        }
	        return json_encode($result);
	    }
	}

	/**
	 * save cache
	 * @time   2017-04-29T10:05:58+0700
	 * @author HaiLong
	 * @param  string $name
	 * @param  string $data
	 * @return
	 */
	public function saveCache($name, $data){
		$name = md5(md5($name));
		$createFolderCache = $this->createFolderCache($name);
		if (!is_dir($this->folderCache)) {
			mkdir($this->folderCache, 0777, true);
		}
		if(!chmod($this->folderCache, 0777)) {
			chmod($this->folderCache, 0777);
		}
		$dir = $this->folderCache.'/'.$createFolderCache;
		$file = $dir.'/'.$name.'.txt';
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		$fp = fopen($file, "w") or die("Please Chmod folder ".$this->folderCache." to 0777");
		fwrite($fp, $data);
		fclose($fp);
	    $index_file = fopen(HALIM_CACHE_PART . '/index.php', "w+");
	    fwrite($index_file, '<?php // Silence is golden.');
	    fclose($index_file);
	}

	/**
	 * delete cache by name
	 * @time   2017-04-29T10:05:58+0700
	 * @author HaiLong
	 * @param  string                   $name
	 * @return array
	 */
	public function delCache($name){
		$result = '';
		$name = md5(md5($name));
		$createFolderCache = $this->createFolderCache($name);
		$file = $this->folderCache.'/'.$createFolderCache.'/'.$name.'.txt';
		if(file_exists($file)){
			if(unlink($file)) {
			    $result = array(
			    	'status' => 1,
			    	'result' => 'Deleted'
			    );
			} else {
			    $result = array(
			    	'status' => 0,
			    	'result' => 'Delete error'
			    );
			}
		}else{
			$result = array(
			    	'status' => 0,
			    	'result' => 'Link not exists'
			    );
		}
		return $result;
	}

	/**
	 * delete all cache by time cache
	 * @time   2017-04-29T10:06:26+0700
	 * @author HaiLong
	 * @param  int                   $timeCache
	 * @return array
	 */
	public function delAllCache($timeCache){
	    $result = array();
	    $getDirContents = $this->getDirContents($this->folderCache);
	    $i = $j = 0;
	    if($getDirContents){
	        foreach ($getDirContents as $key => $value) {
	            if(strpos($value, '.txt')){
	            	$i++;
	                if($timeCache <= (time() - filemtime($value))){
	                	$j++;
						if(unlink($value))
							$result['status'] = 1;
	                    else
	                    	$result['status'] = 0;
	                }
	            }
	        }
	    }
	    $this->removeEmptySubFolders($this->folderCache);
	    $result['total_cache'] = $i;
	    $result['time_limit'] = $timeCache;
	    $result['cache_deleted'] = $j;
	    $result['cache_count'] = $i-$j;
	    return json_encode($result);
	}

	/**
	 * cache count
	 * @time   2019-02-20T10:10:33+0700
	 * @author HaLim
	 * @return array
	 */
	public function cacheCount(){
	    $result = array();
	    $getDirContents = $this->getDirContents($this->folderCache);
	    $i = 1;
	    if($getDirContents){
	        foreach ($getDirContents as $key => $value) {
	            if(strpos($value, '.txt')){
	            	$result['result'] = 1;
	            	$result['total_cache'] = $i;
	            	$i++;
	            }
	        }
	    }

	    return json_encode($result);
	}

	/**
	 * create folder: 0b/01/0b01xxxx.txt
	 * @time   2017-04-29T10:05:19+0700
	 * @author HaiLong
	 * @param  string                   $name
	 * @return string
	 */
	private function createFolderCache($name){
		$folder1 = substr($name, 0, 2);
		$folder2 = substr($name, 2, 2);
		return $folder1.'/'.$folder2;
	}

	/**
	 * get dir cache
	 * @time   2017-04-29T10:06:59+0700
	 * @author HaiLong
	 * @param  string                   $dir
	 * @param  array                    &$results
	 * @return array
	 */
	private function getDirContents($dir, &$results = array()){
	    $files = scandir($dir);

	    foreach($files as $key => $value){
	        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
	        if(!is_dir($path)) {
	            $results[] = $path;
	        } else if($value != "." && $value != "..") {
	            $this->getDirContents($path, $results);
	            $results[] = $path;
	        }
	    }
	    return $results;
	}

	/**
	 * remove all folder empty
	 * @time   2017-04-29T10:07:27+0700
	 * @author HaiLong
	 * @param  string                   $path
	 * @return
	 */
	private function removeEmptySubFolders($path){
	    $empty=true;
	    foreach (glob($path.DIRECTORY_SEPARATOR."*") as $file)
	    {
	      $empty &= is_dir($file) && $this->removeEmptySubFolders($file);
	    }
	    return $empty && @rmdir($path);
	}
}