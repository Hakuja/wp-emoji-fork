<?php
// 直接実行拒否用
if (EMOJIURL == "EMOJIURL") { exit(); }

if (!preg_match('/(index|post|page|options-general)(\-new)?\.php/i',$_SERVER['PHP_SELF'])) { return; }
/*************************************************
  絵文字選択ウィンドウ作成
**************************************************/
// 絵文字の画像場所(外部用url)作成
$imagesurl = get_option('emoji_image_url');
if (!$imagesurl) {
	$imagesurl = get_option('siteurl') . '/wp-includes/images/smilies/';
}
// 絵文字の画像場所(内部用path)作成
$imagepath = get_option('emoji_image_path');
if (!$imagepath) {
	$imagepath = implode(array_slice(explode(DIRECTORY_SEPARATOR, __FILE__), 0, -4), DIRECTORY_SEPARATOR) . '/wp-includes/images/smilies/';
}
// 絵文字の画像表示順リスト作成
$imagesortlist = get_option('emoji_image_sortlist');
// 絵文字リスト作成
$emoji_images = array();
// ファイル指定分
if (file_exists($imagesortlist)) {
	$emoji_images = file($imagesortlist, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
// 存在しないファイルを削除
foreach ($emoji_images as $i => $img) :
echo dirname($imagesortlist) . DIRECTORY_SEPARATOR . rtrim($img);
	if (file_exists(dirname($imagesortlist) . DIRECTORY_SEPARATOR . rtrim($img))) {
		$emoji_images[$i] = strtolower(rtrim($img));
	} else {
		unset($emoji_images[$i]);
	}
endforeach;
// 新規分を追加
$imagedir = dir($imagepath);
while($imagefile=$imagedir->read()) {
	if (strtolower(pathinfo($imagefile,PATHINFO_EXTENSION)) == 'gif') {
		if (!in_array(strtolower($imagefile),$emoji_images)) {
			$emoji_images[] = $imagefile;
		}
	}
}
// 絵文字数よりウィンドウ幅作成
$emoji_sum = count($emoji_images);
$emoji_col = sqrt($emoji_sum);
if (is_float($emoji_col)) {
	$emoji_width = (floor($emoji_col) + 1) * 17;
} else {
	$emoji_width = $emoji_col * 17;
}
?>
<?php
/**************************************************
  スクリプト設定
 **************************************************/
?>
<script type="text/javascript">
// 共通変数
var emoji_insert_link;
// 絵文字一覧
var emoji_list =
<?php
echo '"';
foreach ($emoji_images as $img) {
//	echo '<a href=\"javascript:void(0);\" id=\"emoji_insert_button\"><img src=\"',$imagesurl,$img,'\" style=\"margin:1px;\"/></a>';
	echo '<a href=\"javascript:void(0);\" id=\"emoji_insert_button\" style=\"text-decoration:none;\"><img src=\"',$imagesurl,$img,'\" alt=\"',$img,'\" style=\"margin:1px;\"/></a>';

}
echo '";';
?>
// 絵文字ウィンドウ定義追加
jQuery(function () {
	jQuery("body").append("<div id=\"emojidiv\"></div>");
	jQuery("#emojidiv").css("display", "none");
});
// 絵文字ウィンドウ表示
function emoji_window_show(link) {
	if (!link['calltype']) {
		return;
	}
	emoji_insert_link = link;
	var mousePos = mousePosition(link['event']);
	var emojidiv_left = mousePos.x + 20;
	var emojidiv_top = mousePos.y - 20;
	jQuery(link['divelement']).css("display", "block");
	jQuery(link['divelement']).css("position", "absolute");
	jQuery(link['divelement']).css("left", emojidiv_left);
	jQuery(link['divelement']).css("top", emojidiv_top);
	jQuery(link['divelement']).css("background", "#fff");
	jQuery(link['divelement']).css("padding", "5px");
	jQuery(link['divelement']).css("border", "1px solid #dfdfdf");
	emojidiv_width = <?php echo $emoji_width ?>;
	if ((emojidiv_left + emojidiv_width) > (jQuery(link['divelement']).offsetParent().width() - 40)) {
		emojidiv_left = emojidiv_left - (emojidiv_left + emojidiv_width - jQuery(link['divelement']).offsetParent().width() + 40);
		jQuery(link['divelement']).css("left", emojidiv_left);
	}
	jQuery(link['divelement']).css("width", emojidiv_width + "px");
	jQuery(link['divelement']).html("<div style=\"text-align:right;margin-bottom:5px;\"><a href=\"javascript:void(0);\" id=\"emoji_close_button\" style=\"text-decoration:none;\">閉じる</a></div>" + emoji_list);
	jQuery(function () {
		jQuery(link['divelement']).children("a[id^='emoji_insert_button']").click(function(event){
			emoji_window_hide();
			emoji_insert(event.target.alt);
		});
	});
	jQuery(function () {
		jQuery(link['divelement']).find("#emoji_close_button").click(function(event){
			emoji_window_hide();
		});
	});
	if (emoji_insert_link['onload']) {
		emoji_insert_link['onload'](emoji_insert_link);
	}
}
// マウス位置取得
function mousePosition(event) {
	if (event) {
		if (event.pageX || event.pageY) {
			return {x:event.pageX, y:event.pageY};
		}
		return {
			x:event.clientX + document.body.scrollLeft - document.body.clientLeft,
			y:event.clientY + document.body.scrollTop  - document.body.clientTop
		};
	} else {
		return {x:0, y:0};
	}
}
// 絵文字挿入
function emoji_insert(emoji) {
	var emoji_insert_image_url = "<?php echo $imagesurl ?>" + emoji;
	if (emoji_insert_link['calltype'] != "myself") {
		if (emoji_insert_link['inputelement']) {
			emoji_insert_link['inputelement'].value = emoji_insert_image_url;
		}
		if (emoji_insert_link['onselect']) {
			emoji_insert_link['imageurl'] = emoji_insert_image_url;
			emoji_insert_link['onselect'](emoji_insert_link);
		}
		return;
	}
	var emojiurl = "<img src=\"" + emoji_insert_image_url + "\" alt=\"" + emoji + "\" />";
	var win = window.dialogArguments || opener || parent || top;
	win.send_to_editor(emojiurl);
}
// 絵文字ウィンドウ非表示
function emoji_window_hide() {
	jQuery(emoji_insert_link['divelement']).css("display", "none");
	if (emoji_insert_link['onclose']) {
		emoji_insert_link['onclose'](emoji_insert_link);
	}
}
</script>
