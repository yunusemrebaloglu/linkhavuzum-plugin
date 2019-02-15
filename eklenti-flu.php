<?php
/*
Plugin Name: Link Ekle
Description: Linklerini Biriktirmen İçin Oluşturulmuş Bir Havuz
Author: Yunus Emre Baloğlu
Author URI: yunusemre.co
Version: 1.0
Licence: GNU 
*/

require_once'functions.php';
// admn menüsüne "bizim neden menümüz yok? kaç para ulan bir menü? "diyerek menümüzü basmak üzere fonksiyonumuzu çağırdık
add_action('admin_menu', 'admin_menu_ekle');
// eğer eklentimizi aktif edilirse ihtiyacımız olan veri tabanını oluşturmak için aktive fonksiyonumuza gönderdik.
register_activation_hook( __FILE__, 'myplugin_activate' );
// ekrana içerik basılacaksa "durun benim bu içerik içinde arayacağım bir kısa kod var" diyerek lafa dalıyoruz.
// add_filter('the_content', 'shortcodebul');
// eklentimize ihtiyaç kalmamışsa "çekip gitmeden geridekü bütün eşyaları toplamak gerek" dedik ve geride kalan veri tabanımızı silmek için araya daldık.
add_action('add_meta_boxes', 'my_meta_box');
add_shortcode( 'linkim_short_code', 'findlinkim' );
register_uninstall_hook( __FILE__, 'your_prefix_uninstall' );
