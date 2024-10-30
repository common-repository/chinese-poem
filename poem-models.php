<?php
/**
 * filename: poem-models.php
 * 功能: "唐诗宋词"插件的可用模块;
 * 方法: 每个模块重写"Poem_Inter"接口的"format_poem"访法即可;
 * 注意: 模块所代表的类名和模块资源文件名相同;
 */

/**
 * 诗词接口，便于类LD_Poem的调用
 *
 */
interface Poem_Inter {
	/**
	 * 把从文件中读取的字符串转换成HTML代码
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src);
} //END inter Poem_Inter

/**
 * tang300:     唐诗300首
 */
class tang300 implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		
		$result = "<span class='poem-title' >".$poem_arr[0]."</span><br />";
		$result .= "<span class='poem-author' >".$poem_arr[1]."</span><br />";
		$result .= "<span class='poem-content' >".$poem_arr[2];
		for ($n=3; $n <= count($poem_arr)-3; $n++ ) {
			$result .= "<br />".$poem_arr[$n];
		}
		$result .= "</span>";
		return ereg_replace(chr(10),'',$result);
	}	
} //END class tang300

/**
 * song100:     宋诗100首
 */
class song100 implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		
		$result = "<span class='poem-title' >".$poem_arr[0]."</span><br />";
		$result .= "<span class='poem-author' >".$poem_arr[1]."</span><br />";
		$result .= "<span class='poem-content' >".$poem_arr[2];
		for ($n=3; $n <= count($poem_arr)-3; $n++ ) {
			$result .= "<br />".$poem_arr[$n];
		}
		$result = $result."</span>";
		return ereg_replace(chr(10),'',$result);
	} //END func format_poem
} //END class song100

/**
 * songproses:  宋词
 */
class songproses implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		$result = "<span class='poem-content' >";
		for ($n=0; $n <= count($poem_arr)-4; $n++)
			$result .= $poem_arr[$n]."<br />";
		$poem_at = split('@',$poem_arr[count($poem_arr)-3]);
		$result .= "</span><span class='poem-author' >".$poem_at[0]
			."</span>   <span class='poem-title' >".$poem_at[1]."</span>";
		return ereg_replace(chr(10),'',$result);
	} //END func format_poem
} //END class format_poem

/**
 * caigentan:   菜根谭
 */
class caigentan implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		$result = "<span class='poem-content' >".$poem_arr[0]
			."</sapn><br /><span class='poem-title' >".$poem_arr[1]."</span>";
		return ereg_replace(chr(10),'',$result);
	} //END func format_poem
} //END class caigentan

/**
 * dao:	     道德经
 */
class dao implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		$result = "<span class='poem-content' >";
		for ($n=0; $n <= count($poem_arr)-4; $n++)
			$result .= $poem_arr[$n]."<br />";
		$result .= "</span><span class='poem-title' >".$poem_arr[count($poem_arr)-3]."</span>";
		return ereg_replace(chr(10),'',$result);
	} //END func format_poem
} //END class dao

/**
 * joke:	     笑话集
 */
class joke implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		$result = "<span class='poem-content' >";
		for ($n=0; $n <= count($poem_arr)-4; $n++)
			$result .= $poem_arr[$n]."<br />";
		$result .= $poem_arr[count($poem_arr)-3]."</span>";
		return ereg_replace(chr(10),'',$result);
	} //END func format_poem
} //END class joke

/**
 * maoshici:    毛泽东诗词
 */
class maoshici implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		
		$result = "<span class='poem-title' >".$poem_arr[0]."</span><br />";
		$result = $result."<span class='poem-author' >".$poem_arr[1]."</span><br />";
		$result = $result."<span class='poem-content' >".$poem_arr[2];
		for ($n=3; $n <= count($poem_arr)-3; $n++ ) {
			$result .= "<br />".$poem_arr[$n];
		}
		$result = $result."</span>";
		return ereg_replace(chr(10),'',$result);
	} //END func format_poem
} //END class maoshici

/**
 * maoyulu:     毛泽东语录
 */
class maoyulu implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		$result = "<span class='poem-content' >";
		for ($n=0; $n <= count($poem_arr)-4; $n++)
			$result .= $poem_arr[$n]."<br />";
		$result .= "</span><span class='poem-title' >".$poem_arr[count($poem_arr)-3]."</span>";
		return ereg_replace(chr(10),'',$result);
	} //END func format_poem
} //END class maoyulu

/**
 * proverb:     谚语
 */
class proverb implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		$result = "<span class='poem-content' >".$poem_arr[0]
			."</sapn><br /><span class='poem-title' >".$poem_arr[1]."</span>";
		return ereg_replace(chr(10),'',$result);
	} //END func format_poem
} //END class proverb

/**
 * zengguang:   增广贤文
 */
class zengguang implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		$result = "<span class='poem-content' >".$poem_arr[0]
			."</sapn><br /><span class='poem-title' >".$poem_arr[1]."</span>";
		return ereg_replace(chr(10),'',$result);
	} //END func format_poem
} //END class zengguang

/**
 * lunyu:   论语
 */
class lunyu implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_arr = split(chr(10),$poem_src);
		$result = "<span class='poem-content' >".$poem_arr[0]
			."</sapn><br /><span class='poem-title' >".$poem_arr[1]."</span>";
		return ereg_replace(chr(10),'',$result);
	} //END class format_poem
} //END class lunyu
/**
 * *******************************************
 * Add-Ons  自定义模块
 */

/**
 * niuyu2008:   2008最新的100句超牛的语言
 *
 */
class niuyu2008 implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_array = preg_split('/\n/' , $poem_src, -1, PREG_SPLIT_NO_EMPTY);
		return "<span class='poem-content' >".$poem_array[0]."</span>";
	} //END func format_poem
} //END class niuyu2008

/**
 * wisdom:    名言警句
 * 用于blog首页的浏览器标题栏显示
 */
class wisdom implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_array = preg_split('/\n/' , $poem_src, -1, PREG_SPLIT_NO_EMPTY);
		$title_add = trim($poem_array[0]);
		$js_code = "<script type=\"text/javascript\"> document.title = document.title+' - '+'".$title_add."'; </script>";
		//$js_code = "<script type=\"text/javascript\"> var patrn = /^.+ - /; document.title = patrn.exec(document.title)[0]+'".$title_add."'; </script>";
		return $js_code;
	} //END func format_poem
} //END class wisdom

/**
 * image:    随机显示图像
 * 只有你够无聊把图像地址按照本插进模块的格式写入文件"image",才会出项图像的随机显示
 * 而且这只是个架子，具体怎么写看自个儿了;
 *    说白了，作者我搞了个噱头，却是带忽悠的^_^
 */
class image implements Poem_Inter {
	/**
	 * @see Poem_Inter::format_poem()
	 *
	 * @param string $poem_src
	 */
	public function format_poem($poem_src) {
		$poem_array = preg_split('/\n/' , $poem_src, -1, PREG_SPLIT_NO_EMPTY);
		return "<img src=\"".$poem_array[0]."\" \\>";
	} //END func format_poem
} //END class image
?>