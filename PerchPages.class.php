<?php

class PerchPage extends PerchApp
{
	public $root					= '';
	protected $table				= 'pages';
	protected $pk					= 'ID';
	protected $singular_classname	= 'PerchPagesItem';
	private $registered = array();
	function __construct() {
		parent::__construct();
		$this->root = str_replace(PERCH_LOGINPATH, '', PERCH_PATH);
	}

	public static function fetch()
	{
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	public function add($data)
	{
		if (!$data || !is_array($data)) {
			return false;
		}
		$db	= PerchDB::fetch();
		return $db->insert($this->table, $data);
	}

	public function copy_template($template = false, $location = false)
	{
		if ($template === false || $location === false) {
			return false;
		}
		$file = PERCH_PATH.'/templates/perchpages/' . $template;
		$dir = dirname($location);
		if (is_readable($file)) {
			if (is_writable($dir)) {
				return copy($file, $location);
			}
		}
		return false;
	}

	public function get_list($filter_mode = false, $sort = true)
	{
		$db	= PerchDB::fetch();
		$sql	= 'SELECT *	FROM '.$this->table;
		// Extend this later...
		// switch ($filter_mode) {
		// 	default:
		// 		# code...
		// 		break;
		// }			
		$results	= $db->get_rows($sql);
		if ($sort && PerchUtil::count($results) > 0) {
			$results = PerchUtil::array_sort($results, 'Location');
		}
		return $this->return_instances($results);
	}

	public function get_pages($column = false, $table = false)
	{
		if ($column === false || $table === false) {
			return false;
		}
		$db	= PerchDB::fetch();
		$sql	= 'SELECT DISTINCT ' . $column .
					' FROM ' . PERCH_DB_PREFIX . $table .
					' WHERE ' . $column . ' != `*`';
		$rows   = $db->get_rows($sql);
		if (PerchUtil::count($rows) > 0) {
			$out = array();
			foreach($rows as $row) {
				$out[] = $row[$column];
			}
			return $out;
		}
		return false;
	}

	public function get_templates()
	{
		$a = array();
		if (is_dir(PERCH_PATH.'/templates/perchpages')) {
			if ($dh = opendir(PERCH_PATH.'/templates/perchpages')) {
				while (($file = readdir($dh)) !== false) {
					if(substr($file, 0, 1) != '.') {
						$extension = PerchUtil::file_extension($file);
						if ($extension == 'html' || $extension == 'htm') {
							$a[] = array('filename'=>$file, 'path'=>PERCH_PATH.'/templates/perchpages' . $file, 'label'=>$this->template_display_name($file));
						}
					}
				}
				closedir($dh);
			}
		}
		return $a;
	}

	public function get_writableDirs($dir = false, $level = false)
	{ // it is beastly long...
		if ($dir === false) {
			$dir = $this->root;
		}
		if ($level === false) {
			$level = -1; //becuase we will increment it later...
		}
		$a = array();
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				$level++;
				while (($file = readdir($dh)) !== false) {
					if(substr($file, 0, 1) != '.') {
						$filepath = $dir . '/' . $file;
						if (is_dir($filepath)) {
							if ($filepath !== PERCH_PATH) {
								$writeable = false;
								if (is_writable($filepath)) {
									$writeable = true;
									$prefix = '';
									for ($i = $level; $i >= 0; $i--) {
										$prefix .= '- ';
									}
									$a[] = array('value' => $filepath,
										'label' => $prefix . $file);
								}
								$contents = $this->get_writableDirs($filepath, $level);
								if (!empty($contents) && $writeable) { // I *NEED* a disabled option!
																	 // I could be writable, but not my parent!
																	 // For now, parent must be writeable too. =[
									$a[] = array('value' => $contents[0]['value'],
										'label' => $contents[0]['label']);
								}
							}
						}
					}
				}
				closedir($dh);
			} else {
				return false;
			}
		} else {
			return false;
		}
		return $a;
	}

	public function list_writableDirs()
	{
		$dirs = $this->get_writableDirs();
		array_unshift($dirs, array(
			'value'=>$this->root,
			'label'=>'Root')
		);
		return $dirs;
	}

	public function refresh_display_name($filename)
	{
		$filename = substr($filename, strrpos($filename, DIRECTORY_SEPARATOR) + 1);
		$filename = substr($filename, 0, strrpos($filename, '.'));
		$filename = str_replace('_', ' ', $filename);
		$filename = str_replace('-', ' - ', $filename);
		$filename = ucwords($filename);
		return $filename;
	}

	public function template_display_name($filename)
	{
		$filename = substr($filename, 0, strrpos($filename, '.'));
		$filename = str_replace('_', ' ', $filename);
		$filename = str_replace('-', ' - ', $filename);
		$filename = ucwords($filename);
		return $filename;
	}

	public function test_mysql() {
		$db	= PerchDB::fetch();
		$res = $db->get_table_meta($this->table);
		if ($res === false) {
			$sql = 'CREATE TABLE `' . $this->table . '` (
			 `ID` int(10) NOT NULL auto_increment,
			 `Alias` varchar(255) character set utf8 NOT NULL,
			 `Location` varchar(255) character set utf8 NOT NULL,
			 `Template` varchar(255) character set utf8 NOT NULL,
			 PRIMARY KEY  (`ID`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1';
			$db->execute($sql);
		}
	}

}
?>