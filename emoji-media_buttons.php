<?php
// 直接実行拒否用
if (EMOJIURL == "EMOJIURL") { exit(); }
/*************************************************
  絵文字ボタン表示
**************************************************/
?>
<script type="text/javascript">
jQuery(function () {
	jQuery("#emoji_button").click(function(event){
		var link = new Array();
		link['calltype'] = "myself";
		link['event'] = event;
		link['divelement'] = jQuery("#emojidiv").get();
		emoji_window_show(link);
	});
});
</script>
<a href="javascript:void(0);" id="emoji_button" title="絵文字挿入"><img alt="絵文字挿入" src="<?php echo EMOJIURL; ?>images/smile.gif"/></a>
