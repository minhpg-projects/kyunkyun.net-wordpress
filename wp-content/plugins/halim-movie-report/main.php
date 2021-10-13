<?php

/**
* Plugin name:  Halim Movie Report
* Plugin URI:   http://halimthemes.com
* Description:  Report Broken Movies
* Version:      1.5.1
* Author:       HoangHa
* Author URI:   http://halimthemes.com
* Text Domain:  halimthemes
* Domain Path:  /languages/
*/

add_action('wp_ajax_halim_report', 'halim_movie_report_ajax');
add_action('wp_ajax_nopriv_halim_report', 'halim_movie_report_ajax');
add_action('admin_menu', 'halim_movie_report_add_menu_admin');
add_action('wp_enqueue_scripts', 'halim_report_enqueue_scripts');
register_activation_hook(__FILE__, 'halim_report_ajax_create_db');


function halim_report_enqueue_scripts() {
    if(is_single()) {
        wp_enqueue_script( 'halim-report', plugins_url( 'movie-report.js', __FILE__ ), array(), '' );
    }
}

function halim_plugin_init() {
    load_plugin_textdomain( 'halimthemes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action('init', 'halim_plugin_init');


function halim_report_ajax_create_db(){

    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
    $dbname = 'halim_movie_report';
    $sql = "CREATE TABLE $dbname (
        id int(11) NOT NULL AUTO_INCREMENT,
        date_time datetime NOT NULL,
        content TEXT DEFAULT NULL,
        post int(11),
        episode int(11),
        server int(11),
        seen int(1),
        name varchar(50),
        url varchar(200),
        post_name varchar(150) DEFAULT NULL,
        PRIMARY KEY (id)
    )ENGINE = MyISAM
    DEFAULT CHARACTER SET = utf8
    COLLATE = utf8_general_ci;";
    dbDelta($sql);

}

function halim_movie_report_ajax(){
    global $wpdb;
    $dbname = 'halim_movie_report';
    $clean      = new xssClean();
    $id         = $clean->clean_input(absint($_REQUEST['id_post']));
    $episode    = $clean->clean_input(absint($_REQUEST['episode']));
    $server     = $clean->clean_input(absint($_REQUEST['server']));
    $server     = ($server-1);
    $post_name  = $clean->clean_input(sanitize_text_field($_REQUEST['post_name']));
    $content    = $clean->clean_input(sanitize_text_field($_POST['content']));
    $name       = $clean->clean_input(sanitize_text_field($_POST['name']));
    $time       = date('Y-m-d H:i:s');
    $url        = $clean->clean_input(sanitize_text_field($_REQUEST['halim_error_url']));
    $check_exit = $wpdb->get_results("SELECT url FROM $dbname WHERE url = '$url'", ARRAY_A);
    if($check_exit[0]['url'] !== $url) {
        $wpdb->query("INSERT INTO $dbname SET seen = 0, url = '$url', date_time = '$time', post = $id, episode = '$episode', server = '$server ', post_name = '$post_name', content = '$content', name = '$name'");
    }

    exit;
}

function halim_movie_report_add_menu_admin(){

    global $wpdb;
    $dbname = 'halim_movie_report';
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $dbname WHERE seen = 0");
    $menu = __('Broken Movie ', 'halimthemes');
    if($count > 0)
        $menu .= '<span class="awaiting-mod count-' . $count . '"><span class="pending-count"> ' . $count . '</span></span>';
    add_menu_page(__('Broken Movie', 'halimthemes'), $menu, 'edit_pages', 'halim-movie-report', 'halim_movie_report_UI', 'dashicons-warning');

}

function halim_movie_report_UI(){

    global $wpdb;
    $dbname = 'halim_movie_report';
    if(isset($_GET['halim_action']) && $_GET['halim_action'] == 'del') {
        $wpdb->query("DELETE FROM $dbname WHERE id={$_GET['id']}");
    } elseif(isset($_GET['halim_action']) && $_GET['halim_action'] == 'del_all') {
        $wpdb->query("DELETE FROM $dbname");
    }

    $page = (int) (isset($_GET['halim_page'])) ? $_GET['halim_page'] : 1;
    $show = (int) (isset($_GET['halim_show'])) ? $_GET['halim_show'] : 20;
    $pos = ($page - 1) * $show;
    $data = $wpdb->get_results("SELECT * FROM $dbname ORDER BY id DESC LIMIT $pos, $show;");
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $dbname");
    $wpdb->query("UPDATE $dbname SET seen = 1 WHERE seen = 0");

    ?>
    <style>
        .halim-pagination {
            padding: 10px 0;
            border: 1px solid #e1e1e1;
            background: #fff;
            margin-bottom: -1px;
        }
        .halim-page{
            color: #a0a5aa;
            background: rgba(0,0,0,.05);
            padding: 5px 10px 5px;
            font-size: 16px;
            font-weight: 400;
        }
        .halim-num {
            color: #a0a5aa;
            background: rgb(255, 255, 255);
            padding: 5px 10px;
            font-size: 14px;
        }
        .halim-links{
            float:right;
            margin-right:20px;
        }
        th.manage-column {
            background: #333;
            color: #fff!important;
        }
        .halim-num a {
            text-decoration: none;
        }

        span.auto, span.bot {
            background: #489818;
            color: #fff;
            padding: 1px 6px 4px;
            line-height: 20px;
            font-size: 12px;
            border-radius: 2px;
        }
        span.bot {
            background: #e24e4e;
        }
        span.user {
            background: #d8d8d8;
            border: 1px solid #d8d8d8;
            padding: 0 5px 3px;
            border-radius: 2px;
        }
        span.by_user {
            padding: 3px 0;
        }
    </style>
    <h2><?php _e('List Broken Movie', 'halimthemes'); ?></h2>
    <div class="halim-pagination">
        <span class="halim-num"><?php _e('Broken Movie', 'halimthemes'); ?>: [<strong style="color: red;"><?php echo $count?></strong>]</span>
        <span class="halim-num"><a href="<?php echo admin_url('admin.php?page=halim-movie-report&halim_action=del_all')?>"><?php _e('Delete all', 'halimthemes'); ?></a></span>
        <span class="halim-links">
        <?php if($page > 1):?>
            <a class="halim-page" title="Go to the previous page" href="<?php echo admin_url('admin.php?page=halim-movie-report&halim_page=' . ($page - 1))?>">‹ Prev</a>
        <?php endif;?>
        <?php if($count/$show > $page):?>
            <a class="halim-page" title="Go to the previous page" href="<?php echo admin_url('admin.php?page=halim-movie-report&halim_page=' . ($page + 1))?>">Next ›</a>
        <?php endif;?>
        </span>
    </div>
    <table cellspacing="0" class="widefat comments fixed">
        <thead>
            <tr>
                <th class="manage-column" scope="col"><?php _e('Name', 'halimthemes'); ?></th>
                <th class="manage-column" scope="col" colspan="3"><?php _e('Description', 'halimthemes'); ?></th>
                <th class="manage-column" scope="col"><?php _e('Time', 'halimthemes'); ?></th>
                <th class="manage-column" scope="col"><?php _e('Action', 'halimthemes'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($data) == 0):?>
                <tr><td colspan="3"><br /><?php _e('The list is empty :))', 'halimthemes'); ?><br /><br /></td></tr>
            <?php endif;
             foreach($data as $item):?>
                <tr>
                    <td colspan="1"><?php echo ($item->name == 'BOT') ? '<span class="bot">'.$item->name.'</span>' : '<span class="user">'.$item->name.'</span>' ?> </td>
                    <td colspan="3">
                        <?php echo ($item->content == 'Auto report') ? '<span class="auto">'.$item->content.'</span>' : '<span class="by_user">'.$item->content.'</span>'; ?>
                        <br />
                        <a href="<?php echo $item->url?>" target="_blank">
                          <strong style="color: red;"><?php echo $item->post_name;?></strong>
                          <br>
                          <?php echo $item->url?>
                        </a>
                    </td>
                    <td><?php echo date("g:i m/d/Y", strtotime($item->date_time))?></td>
                    <td colspan="1">
                        <a href="<?php echo admin_url('admin.php?page=halim-episode-manager&act=edit_ep&post_id='.$item->post.'&server='.$item->server.'&episode='.$item->episode)?>" target="_blank">
                            <?php _e('Edit', 'halimthemes'); ?></a> | <a href="<?php echo admin_url('admin.php?page=halim-movie-report&halim_action=del&id='.$item->id.'')?>"><?php _e('Delete', 'halimthemes'); ?></a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php
}