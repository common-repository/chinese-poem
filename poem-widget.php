<?php
/**
 * ********************************************
 * filename: poem-widget.php
 * 功能: 侧边栏小挂件
 * 方法: 能省就省......
 */

/**
 * 唐诗宋词的 Widget
 *
 * @param unknown_type $args
 */
function chinese_poem_widget($args) {
    extract($args);
    
	$poem_widget_options = get_option('poem-widget');
    
	$poem_widget_title = $poem_widget_options['ld_widget_title'];
	if (empty($poem_widget_title))
    	$poem_widget_title = '唐诗宋词';
    	
    $poem_widget_css = TRUE;
    if ($poem_widget_options['ld_use_css'] == 'no') {
    	$poem_widget_css = FALSE;
    }
	
    $poem_widget_modules_array =array();
    // 11 modules ! I will work to die.
    if ($poem_widget_options['ld_custom_modules'] == 'no') {
    	if ($poem_widget_options['ld_module_tang300'] == "tang300") 
    		array_push($poem_widget_modules_array,'tang300');
    	if ($poem_widget_options['ld_module_song100'] == "song100") 
    		array_push($poem_widget_modules_array,'song100');
    	if ($poem_widget_options['ld_module_songproses'] == "songproses") 
    		array_push($poem_widget_modules_array,'songproses');
    	if ($poem_widget_options['ld_module_caigentan'] == "caigentan") 
    		array_push($poem_widget_modules_array,'caigentan');
    	if ($poem_widget_options['ld_module_dao'] == "dao") 
    		array_push($poem_widget_modules_array,'dao');
    	if ($poem_widget_options['ld_module_joke'] == "joke") 
    		array_push($poem_widget_modules_array,'joke');
    	if ($poem_widget_options['ld_module_lunyu'] == "lunyu") 
    		array_push($poem_widget_modules_array,'lunyu');
    	if ($poem_widget_options['ld_module_proverb'] == "proverb") 
    		array_push($poem_widget_modules_array,'proverb');
    	if ($poem_widget_options['ld_module_zengguang'] == "zengguang") 
    		array_push($poem_widget_modules_array,'zengguang');
    	if ($poem_widget_options['ld_module_maoshici'] == "maoshici") 
    		array_push($poem_widget_modules_array,'maoshici');
    	if ($poem_widget_options['ld_module_maoyulu'] == "maoyulu") 
    		array_push($poem_widget_modules_array,'maoyulu');
    } //END if $poem_widget_options['ld_custom_modules'] == no
    else {
    	$poem_widget_modules = $poem_widget_options['ld_modules'];
    	$poem_widget_modules_array = preg_split('/[\s,]+/',$poem_widget_modules,-1,PREG_SPLIT_NO_EMPTY);
    	//var_dump($poem_widget_modules_array);
    } // END else ld_custom_modules == 'yes'
    // $poem_widget_modules_array try to define
    if (empty($poem_widget_modules_array))
    	array_push($poem_widget_modules_array,'tang300','song100','songproses');	
	// END choose poem modules
    
    echo $before_widget;
	echo $before_title .$poem_widget_title. $after_title;
	if ($poem_widget_options['ld_use_time'] == 'yes') {
    	$poem_widget_timespan = $poem_widget_options['ld_timespan'];
    	if (empty($poem_widget_timespan))
    		$poem_widget_timespan = 30; 
    	show_chinese_poetry($poem_widget_modules_array, $poem_widget_css, $poem_widget_timespan);
    } else {
    	show_chinese_poem($poem_widget_modules_array, $poem_widget_css);
    } //END if $poem_widget_options['ld_use_time']
	echo $after_widget;
} //END func chinese_poem_widget

/**
 * 侧边栏挂件选项
 *
 */
function chinese_poem_widget_options() {
/*	$poem_modules = array('caigentan' => FALSE,
						'dao' => FALSE,
						'joke' => FALSE,
						'lunyu' => FALSE,
						'maoshici' => FALSE,
						'maoyulu' => FALSE,
						'proverb' => FALSE,
						'song100' => FALSE,
						'songproses' => FALSE,
						'tang300' => FALSE,
						'zengguang' => FALSE );*/
	$new_poem_widget_options = $poem_widget_options = get_option('poem-widget');
	
	if ( $_POST["ld_options_submit"] ) { 
		$new_poem_widget_options['ld_widget_title'] = strip_tags(stripslashes($_POST["ld_widget_title"]));
		$new_poem_widget_options['ld_custom_modules'] = $_POST["ld_custom_modules"];
		if (empty($new_poem_widget_options['ld_custom_modules']))
			$new_poem_widget_options['ld_custom_modules'] = 'no';
		$new_poem_widget_options['ld_use_css'] = $_POST["ld_use_css"];
		if (empty($new_poem_widget_options['ld_use_css']))
			$new_poem_widget_options['ld_use_css'] = 'yes';		
		$new_poem_widget_options['ld_use_time'] = $_POST["ld_use_time"];
		if (empty($new_poem_widget_options['ld_use_time']))
			$new_poem_widget_options['ld_use_time'] = 'no';
		
		if ($new_poem_widget_options['ld_custom_modules'] == 'no') {
			/*foreach ($poem_modules as $key => $value ) {
				if (isset($_POST['ld_'.$key])) {
					$poem_modules[$key] = TRUE;
					$new_poem_widget_options['ld_modules'] .= ','.$key;
				}
			}*/
			// 11 modules Shit!!!
			$new_poem_widget_options['ld_module_tang300'] = $_POST["ld_tang300"];
			$new_poem_widget_options['ld_module_song100'] = $_POST["ld_song100"];
			$new_poem_widget_options['ld_module_songproses'] = $_POST["ld_songproses"];
			$new_poem_widget_options['ld_module_caigentan'] = $_POST["ld_caigentan"];
			$new_poem_widget_options['ld_module_dao'] = $_POST["ld_dao"];
			$new_poem_widget_options['ld_module_joke'] = $_POST["ld_joke"];
			$new_poem_widget_options['ld_module_lunyu'] = $_POST["ld_lunyu"];
			$new_poem_widget_options['ld_module_proverb'] = $_POST["ld_proverb"];
			$new_poem_widget_options['ld_module_zengguang'] = $_POST["ld_zengguang"];
			$new_poem_widget_options['ld_module_maoshici'] = $_POST["ld_maoshici"];
			$new_poem_widget_options['ld_module_maoyulu'] = $_POST["ld_maoyulu"];
		} else {
			$new_poem_widget_options['ld_modules'] = strip_tags(stripslashes($_POST["ld_modules"]));
		}
		
		if ($new_poem_widget_options['ld_use_time'] == 'yes') {
			$new_poem_widget_options['ld_timespan'] = strip_tags(stripslashes($_POST["ld_timespan"]));
		}
		if (empty($new_poem_widget_options['ld_timespan']))
			$new_poem_widget_options['ld_timespan'] = 30;
		
		if ( $poem_widget_options != $new_poem_widget_options ) { 
			$poem_widget_options = $new_poem_widget_options;
			update_option('poem-widget', $poem_widget_options);
		}
	}
	$poem_widget_title = attribute_escape($poem_widget_options['ld_widget_title']);
?>
<p><label for="ld_widget_title"><?php _e('Title:'); ?> <input style="width: 250px;" id="ld_widget_title" name="ld_widget_title" type="text" value="<?php echo $poem_widget_title; ?>" /></label></p>
	<hr />
<!-- form method="post" -->
<!-- 选择模块 -->
<input type="radio" <?php if ($poem_widget_options['ld_custom_modules'] == 'no')  echo "checked=\"checked\""; ?> id="ld_custom_modules" name="ld_custom_modules" value="no" /> 选择可用模块
	<ul style="list-style-type: none">
		<li><label for="ld_tang300" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_tang300'] == 'tang300')  echo "checked=\"checked\""; ?> id="ld_tang300" name="ld_tang300" value="tang300" /></label> tang300  |  唐诗300首</li>
		<li><label for="ld_song100" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_song100'] == 'song100') echo "checked=\"checked\""; ?> id="ld_song100" name="ld_song100" value="song100" /></label> song100  |  宋诗100首</li>
		<li><label for="ld_songproses" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_songproses'] == 'songproses') echo "checked=\"checked\""; ?> id="ld_songproses" name="ld_songproses" value="songproses" /></label> songproses  |  宋词</li>
		<li><label for="ld_caigentan" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_caigentan'] == 'caigentan') echo "checked=\"checked\""; ?> id="ld_caigentan" name="ld_caigentan" value="caigentan" /></label> caigentan  |  菜根谭</li>
		<li><label for="ld_dao" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_dao'] == 'dao') echo "checked=\"checked\""; ?> id="ld_dao" name="ld_dao" value="dao" /></label> dao  |  道德经</li>
		<li><label for="ld_joke" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_joke'] == 'joke') echo "checked=\"checked\""; ?> id="ld_joke" name="ld_joke" value="joke" /></label> joke  |  笑话集</li>
		<li><label for="ld_lunyu" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_lunyu'] == 'lunyu') echo "checked=\"checked\""; ?> id="ld_lunyu" name="ld_lunyu" value="lunyu" /></label> lunyu  |  论语</li>
		<li><label for="ld_proverb" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_proverb'] == 'proverb') echo "checked=\"checked\""; ?> id="ld_proverb" name="ld_proverb" value="proverb" /></label> proverb  |  谚语</li>
		<li><label for="ld_zengguang" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_zengguang'] == 'zengguang') echo "checked=\"checked\""; ?> id="ld_zengguang" name="ld_zengguang" value="zengguang" /></label> zengguang  |  增广贤文</li>
		<li><label for="ld_maoshici" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_maoshici'] == 'maoshici') echo "checked=\"checked\""; ?> id="ld_maoshici" name="ld_maoshici" value="maoshici" /></label> maoshici  |  毛泽东诗词</li>
		<li><label for="ld_maoyulu" ><input type="checkbox" <?php if ($poem_widget_options['ld_module_maoyulu'] == 'maoyulu') echo "checked=\"checked\""; ?> id="ld_maoyulu" name="ld_maoyulu" value="maoyulu" /></label> maoyulu  |  毛泽东语录</li>
	</ul>
<input type="radio" <?php if ($poem_widget_options['ld_custom_modules'] == 'yes')  echo "checked=\"checked\""; ?> id="ld_custom_modules" name="ld_custom_modules" value="yes" /> 自定义模块(用','号隔开模块)
	<label for="ld_modules" ><input type="text" id="ld_modules" name="ld_modules" value="<?php echo $poem_widget_options['ld_modules'] ?>" size="25" /></label>
<br /><br /><hr />
<!-- 是否使用CSS风格 -->
<select name="ld_use_css">
	<option value="yes" <?php if ($poem_widget_options['ld_use_css'] == 'yes') echo "selected=\"selected\""; ?>>True</option>
	<option value="no" <?php if ($poem_widget_options['ld_use_css'] == 'no') echo "selected=\"selected\""; ?>>False</option>
</select> 是否使用CSS风格
<br /><br /><hr />
<!-- 时间间隔 -->
<input type="radio" <?php if ($poem_widget_options['ld_use_time'] == 'no')  echo "checked=\"checked\""; ?> id="ld_use_time" name="ld_use_time" value="no" /> 刷新一次更新一首诗
<br /><input type="radio" <?php if ($poem_widget_options['ld_use_time'] == 'yes')  echo "checked=\"checked\""; ?> id="ld_use_time" name="ld_use_time" value="yes" /> 自定义更新时间： 
	<label for="ld_timespan" ><input type="text" id="ld_timespan" name="ld_timespan" value="<?php echo $poem_widget_options['ld_timespan'] ?>" size="5" /></label>分钟
<br /><span style="color:red" >注意：</span>使用定时更新前请确保插件目录下"poem.tmp"文件的可写权限(666)
<input type="hidden" id="ld_options_submit" name="ld_options_submit" value="1" />
<!-- /form -->
<?php
} //END func chinese_poem_widget_options

/**
 * 注册"唐诗宋词"插件的 Widget
 *
 */
function chinese_poem_register_plugin() {
//	if (function_exists('register_sidebar_widget') && function_exists('register_widget_control'))
	register_sidebar_widget('唐诗宋词', 'chinese_poem_widget');
	register_widget_control('唐诗宋词', 'chinese_poem_widget_options', 300, 600);
} //END func chinese_poem_register_plugin

// 加载 hook
add_action('plugins_loaded', 'chinese_poem_register_plugin');
?>