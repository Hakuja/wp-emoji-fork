<?php
/*
Plugin Name: emoji
Plugin URI: http://wppluginsj.sourceforge.jp/emoji/
Description: 絵文字を使用出来るようにする。
Version: 1.3.0
Author: Takahiro Yamada
Author URI: http://www.syshawa.co.jp/blog/?page_id=102
*/
/*  Copyright 2009 Takahiro Yamada (email : taka@syshawa.co.jp)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// 直接実行拒否用
if (ABSPATH == "ABSPATH") { exit(); }

/*********************************************************************
   パラメタの追加
 *********************************************************************/
add_option('emoji_image_url');
add_option('emoji_image_path');
add_option('emoji_image_sortlist');

/*********************************************************************
   共通変数定義
 *********************************************************************/
define('EMOJIURL', get_option('siteurl') . '/wp-content/plugins/emoji/');

/*********************************************************************
   パラメタ管理
 *********************************************************************/
// パラメタ管理用のメニュー作成のため、管理メニューに追加するフック
add_action('admin_menu', 'emoji_menu');
// パラメタ管理用のメニュー作成のため、管理メニューに追加するフック関数
function emoji_menu() {
	add_options_page('絵文字用オプション設定', '絵文字の設定', 'administrator', 'emoji-options.php', 'emoji_options_page');
}
// パラメタ管理用のページ作成のための関数
function emoji_options_page() {
//コンテンツファイルインクルード
	include('emoji-options.php');
}

/*********************************************************************
   絵文字ボタン表示
 *********************************************************************/
// 絵文字ボタン表示のため追加するフック
add_action('media_buttons', 'emoji_media_buttons', 100);
// 絵文字ボタン表示のため追加するフック関数
function emoji_media_buttons() {
//コンテンツファイルインクルード
	include('emoji-media_buttons.php');
}

/*********************************************************************
   絵文字選択ウィンドウ作成
 *********************************************************************/
// 絵文字選択ウィンドウ作成のため追加するフック
add_action('admin_head', 'emoji_scripts', 100);
// 絵文字選択ウィンドウ作成のため追加するフック関数
function emoji_scripts() {
//コンテンツファイルインクルード
	include('emoji-scripts.php');
}

?>
