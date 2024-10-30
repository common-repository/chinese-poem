<?php
/*
Plugin Name: 唐诗宋词(chinese poem)
Plugin URI: http://mifunny.info/wp-plugin-chinese-poem-84.html
Description: 随机显示唐诗宋词,也可自由组合11个模块(0.2版加入Widget)。
Version: 0.3
Author: LD King
Author URI: http://mifunny.info
License: GPL v3
*/

/**
 * ChangeLog: 
 * 		0.3  修正了判断文本段的正则表达式	2008/09/04
 */
include_once 'poem-models.php';
include_once 'poem-widget.php';

/**
 * 随机提取一首诗
 * 格式化后输出
 */
class LD_Poem {
	private $poem_src, $poem_file;
	private $poem; //Poem_Inter Object
	//Chinese Poem's folder PATH and URL
	public static $plugin_dir, $plugin_url;
	//CSS style
	private $css_title, $css_author, $css_content; 

	/**
	 * 选泽一个模块,构造函数
	 *
	 * @param array $files 默认只有三个模块：唐诗300首、宋诗100首、宋词
	 * @param bool $ccs 是否加载CSS风格
	 */
	public function __construct($files = 
		array('tang300', 'song100', 'songproses'), $css = TRUE) 
	{	
		// get plugin path
		if (self::$plugin_dir == '' && self::$plugin_url == '') {
			self::find_plugin_path();
		}
		
		if (empty($files)) {
			$files = array('tang300', 'song100', 'songproses');
			//print_r($files);
			//exit("<p>I don't understand the array.</p>");
		}
		//add_css ？
		if ($css == TRUE) {
			$this->add_css();
			//add_action('wp_head', array(&$this, 'add_css'));
		}
		for ($i=0; $i<count($files); $i++) {
			if (!file_exists(self::$plugin_dir.$files[$i])) {
				exit('<p>File '.self::$plugin_url.$files[$i].' is not exists.</p>');
			}				
		} //END for file_exists
		//poem source based random number
		$rand_num = mt_rand(0, count($files)-1);
		$this->poem_file = $files[$rand_num];
		$this->poem_src = $this->get_poem(self::$plugin_dir.$this->poem_file);
	} //END func __construct

	/**
	 * 从文件中随机抽取一首诗
	 *
	 * @param string $filename
	 * @return string
	 */
	private function get_poem($filename) {
		@ $fb = fopen($filename,'rb',TRUE); //open file
		if (!$fb) 	{
			exit("<p>I can't open this file: ".$filename."<p>");
		}
		$n = 0; // the number of poem
		while (!feof($fb)) { //count poems
			$tang = fgets($fb, 999);
			//if ( ereg('[%]', $tang) )
			if (preg_match('/^\%[ |\t]*\n/',$tang))
				$n++;
		}
		$rand_num = mt_rand(1, $n); //random number
		rewind($fb); //back to 0 node
		$begin = $end = 0; 
		for($num = 0; !feof($fb); ) {
			$tang = fgets($fb,999);
			if (preg_match('/^\%[ |\t]*\n/',$tang)) {
				$num++;
				if ($num == $rand_num ) {
					$end = ftell($fb);
					break; //get poem node
				}
				else
					$begin = ftell($fb);			 
			}
		} //END for feof($fb)
		$len=$end - $begin;
		fseek($fb, $begin, SEEK_SET);
		$result = fread($fb,$len);
		fclose($fb);  //close file

		return $result;
	} //END func get_poem_src	
	
	public function __get($name){
		return $this->$name;
	}

	/**
	 * 添加CSS风格
	 * （从poem.css文件读取后通过正则表达式提取变成内联式
	 * 其实就一个字： 晕！）foolish
	 */
	public function add_css() {
		//echo "<link rel=\"stylesheet\" href=\"".$this->plugin_url."poem.css\" />\n";
		if (!file_exists(self::$plugin_dir."poem.css")) {
			echo "File： ".self::$plugin_url."poem.css is not exists.<br />";
		} 
		else {
			$file_content = file_get_contents(self::$plugin_dir."poem.css", FILE_USE_INCLUDE_PATH);
			// clean the note and LF
			$file_content = preg_replace('/(\/\*(\s|.)*?\*\/)|\s/',' ',$file_content);
			$css_style = array();
			preg_match('/span\.poem\-title\s*\{(.*?)\}/', $file_content, $css_style);
			$this->css_title = "style=\"".$css_style[1]."\"";
			preg_match('/span\.poem\-author\s*\{(.*?)\}/', $file_content, $css_style);
			$this->css_author = "style=\"".$css_style[1]."\"";
			preg_match('/span\.poem\-content\s*\{(.*?)\}/', $file_content, $css_style);
			$this->css_content = "style=\"".$css_style[1]."\"";
		}
	} //END func add_css

	/**
	 * 调用格式化接口，输出诗词
	 *
	 */
	public function display(Poem_Inter $poem) {
		$this->poem=$poem;
		//echo $this->poem->format_poem($this->poem_src);
		$poem_display = $this->poem->format_poem($this->poem_src);
		$poem_display = preg_replace('/class\=\'poem\-title\'/',$this->css_title,$poem_display);
		$poem_display = preg_replace('/class\=\'poem\-author\'/',$this->css_author,$poem_display);
		$poem_display = preg_replace('/class\=\'poem\-content\'/',$this->css_content,$poem_display);
		return $poem_display;
	} //END func display
	
	/**
	 * 得到插件目录地址和URL地址
	 */
	public static function find_plugin_path() {
		//get the plugin path 
		$wp_plugin_dir = ( defined('WP_PLUGIN_DIR') ) ? WP_PLUGIN_DIR : ABSPATH . PLUGINDIR;
		self::$plugin_dir = $wp_plugin_dir."/".dirname(plugin_basename (__FILE__))."/";
		//get the plugin url 
		$wp_plugin_url = ( defined('WP_PLUGIN_URL') ) ? WP_PLUGIN_URL : get_option('siteurl') . PLUGINDIR;
		self::$plugin_url = $wp_plugin_url."/".dirname(plugin_basename (__FILE__))."/";
	} //END static func get_plugin_path	
	
	/**
	 * 静态方法，返回插件物理目录
	 */
	public static function get_plugin_dir() {
		if (self::$plugin_dir == '') { 
			self::find_plugin_path();
		}
		return self::$plugin_dir;
	} //END static func get_plugin_dir
	
	/**
	 * 静态方法，返回插件URL地址
	 */
	public static function get_plugin_url() {
		if (self::$plugin_url == '') {
			self::find_plugin_path();
		}
		return self::$plugin_url;
	} //END static func get_plugin_url
} //END class LD_Poem	

/**
 * ******************************************
 * 外部调用函数
 * 方法1: show_chinese_poem() 随机显示一条记录
 * 方法2: show_chinese_poetry() 根据时间间隔随机显示记录
 */

/**
 * [外部调用函数]随机显示一首诗歌
 *
 * @param array $model 默认只有三个模块：唐诗300首、宋诗100首、宋词
 * @param bool $ccs 是否加载CSS风格
 */
function show_chinese_poem(
	$modules = array('tang300', 'song100', 'songproses'), $css = TRUE ) 
{
	$cn_poem = new LD_Poem($modules, $css);
	echo $cn_poem->display(new $cn_poem->poem_file);
	unset($cn_poem);
} //END func show_chinese_poem

/**
 * [外部调用函数]随机显示一首诗歌(节能版)
 *
 * @param array $model 默认只有三个模块：唐诗300首、宋诗100首、宋词
 * @param bool $ccs 是否加载CSS风格
 * @param date $timspan 诗词刷新的时间间隔 默认为30分钟
 */
function show_chinese_poetry(
	$modules = array('tang300', 'song100', 'songproses'), $css = TRUE, $timspan = 30) 
{
	$timspan *= 60;
	//get the plugin temp file path 
	$plugin_tmp_file = LD_Poem::get_plugin_dir()."poem.tmp";

	if (!file_exists($plugin_tmp_file) 
		|| abs(date('U') - filemtime($plugin_tmp_file)) > $timspan) {
		// display poem
		$cn_poem = new LD_Poem($modules, $css);
		$ouput = $cn_poem->display(new $cn_poem->poem_file);
		echo $ouput;
		unset($cn_poem);
		
		//write into temp file
		file_put_contents($plugin_tmp_file, $ouput, FILE_USE_INCLUDE_PATH);
	} //END if write poem
	else {
		$ouput = file_get_contents($plugin_tmp_file, FILE_USE_INCLUDE_PATH);
		echo $ouput;
	} //END else read file
} //END func show_chinese_poetry

/*$bate = new LD_Poem();
add_action('wp_head', array(&$bate, 'add_css'));
unset($bate); */
?>