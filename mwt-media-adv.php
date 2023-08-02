<?php
/**
 * Plugin Name: MWT-媒體庫優化
 * Plugin URI: https://www.minwt.com
 * Description: 關閉媒體庫上傳圖片時，自動生成多個圖片尺寸，在媒體庫中顯示圖片的檔案大小
 * Version: 1.1
 * Author: minwt
 * Author URI: https://www.minwt.com/
 */
add_action('init', 'disable_other_image_sizes');
add_action('intermediate_image_sizes_advanced', 'disable_image_sizes');
add_filter('big_image_size_threshold', '__return_false');
add_filter('manage_upload_columns', 'Create_column_file_size' );
add_action('manage_media_custom_column', 'Show_column_file_size', 10, 2 );

function disable_image_sizes($sizes) {
	unset($sizes['thumbnail']);  
	unset($sizes['medium']);
	unset($sizes['large']);
	unset($sizes['medium_large']);
	unset($sizes['1536x1536']);
	unset($sizes['2048x2048']);
}
function disable_other_image_sizes() {
	remove_image_size('post-thumbnail');
	remove_image_size('another-size');
}
function Create_column_file_size( $columns ) {
    $columns['filesize'] = '檔案大小';

    return $columns;
}
function Show_column_file_size( $column_name, $media_item ) {
    if ( 'filesize' != $column_name || !wp_attachment_is_image( $media_item ) ) {
      return;
    }
    $filesize = filesize( get_attached_file( $media_item ) );
    $filesize = size_format($filesize, 2);
    echo $filesize;
}
?>