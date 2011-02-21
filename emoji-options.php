<?php
/*************************************************
  絵文字用オプション管理画面
**************************************************/
// 直接実行拒否用
if (EMOJIURL == "EMOJIURL") { exit(); }
?>
<div class="wrap">
	<h2>絵文字の設定</h2>
	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row" nowrap>絵文字の画像場所(外部用url)</th>
				<td><input type="text" style="width:100%" name="emoji_image_url" value="<?php echo get_option('emoji_image_url'); ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"></th>
				<td>※外部から参照出来る画像の場所を指定する。<br>
					例）<br>
					<font color="red">http://www.example.jp/blog/wp-content/uploads/emoji/</font><br>
					未設定時は下記を使用）<br>
					<font color="red"><?php echo get_option('siteurl') . '/wp-includes/images/smilies/' ?></font>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" nowrap>絵文字の画像場所(内部用path)</th>
				<td><input type="text" style="width:100%" name="emoji_image_path" value="<?php echo get_option('emoji_image_path'); ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"></th>
				<td>※画像が存在する場所を絶対パスで指定する。<br>
					例）<br>
					<font color="red">/example/wordpress/wp-content/uploads/emoji/</font> (UNIX/Linux等)<br>
					<font color="red">\\server\example\wordpress\wp-content\uploads\emoji\</font> (Windows等)<br>
					<font color="red">c:\example\wordpress\wp-content\uploads\emoji\</font> (Windows等)<br>
					未設定時は下記を使用）<br>
					<font color="red"><?php echo implode(array_slice(explode(DIRECTORY_SEPARATOR, __FILE__), 0, -4), DIRECTORY_SEPARATOR) . '\\wp-includes\\images\\smilies\\' ?></font>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" nowrap>絵文字の画像表示順リスト</th>
				<td><input type="text" style="width:100%" name="emoji_image_sortlist" value="<?php echo get_option('emoji_image_sortlist'); ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"></th>
				<td>※画像の並び順を指定するファイルの存在する場所を絶対パスで指定する。<br>
					例）<br>
					<font color="red">/example/wordpress/wp-content/uploads/emoji/emoji_list.txt</font> (UNIX/Linux等)<br>
					<font color="red">\\server\example\wordpress\wp-content\uploads\emoji\emoji_list.txt</font> (Windows等)<br>
					<font color="red">c:\example\wordpress\wp-content\uploads\emoji\emoji_list.txt</font> (Windows等)<br>
					注意事項<br>
					※ファイルの内容は一行につき１ファイルを記述し改行する事。<br>
					※記述されたファイルが存在しない場合は無視される。<br>
					※記述されたファイル以降に記述されていないgifファイルがファイル名順に表示される、よって当ファイルを指定しない場合は上記「絵文字の画像場所(内部用path)」で指定されたフォルダのファイルが表示される。
				</td>
			</tr>
		</table>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="emoji_image_url,emoji_image_path,emoji_image_sortlist" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>
