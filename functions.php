<?php
/**
 * загружаемые стили и скрипты
 **/


function load_style_script() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('script.js', get_template_directory_uri() . '/script/script.js');
  wp_enqueue_style('normalize', get_template_directory_uri() . '/style/normalize.css');
  wp_enqueue_style('clearfix', get_template_directory_uri() . '/style/clearfix.css');
  wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('HelveticaNeueCyrBlack_1', get_template_directory_uri() . '/fonts/HelveticaNeueCyrBlack_1.css');
  wp_enqueue_style('HelveticaNeueCyrBlackItalic_1', get_template_directory_uri() . '/fonts/HelveticaNeueCyrBlackItalic_1.css');
  wp_enqueue_style('HelveticaNeueCyrBold_1', get_template_directory_uri() . '/fonts/HelveticaNeueCyrBold_1.css');
  wp_enqueue_style('HelveticaNeueCyrBoldItalic_1', get_template_directory_uri() . '/fonts/HelveticaNeueCyrBoldItalic_1.css');
  wp_enqueue_style('HelveticaNeueCyrItalic_1', get_template_directory_uri() . '/fonts/HelveticaNeueCyrItalic_1.css');
  wp_enqueue_style('HelveticaNeueCyrLight_2', get_template_directory_uri() . '/fonts/HelveticaNeueCyrLight_2.css');
  wp_enqueue_style('HelveticaNeueCyrLightItalic_1', get_template_directory_uri() . '/fonts/HelveticaNeueCyrLightItalic_1.css');
  wp_enqueue_style('HelveticaNeueCyrMedium_1', get_template_directory_uri() . '/fonts/HelveticaNeueCyrMedium_1.css');
  wp_enqueue_style('HelveticaNeueCyrThin_1', get_template_directory_uri() . '/fonts/HelveticaNeueCyrThin_1.css');
  wp_enqueue_style('HelveticaNeueCyrThinItalic_1', get_template_directory_uri() . '/fonts/HelveticaNeueCyrThinItalic_1.css');
  wp_enqueue_style('HelveticaNeueCyrUltraLight_2', get_template_directory_uri() . '/fonts/HelveticaNeueCyrUltraLight_2.css');
  wp_enqueue_style('HelveticaNeueCyrUltraLightItalic', get_template_directory_uri() . '/fonts/HelveticaNeueCyrUltraLightItalic.css');
  wp_enqueue_style('HelveticaNeueCyrRoman_1', get_template_directory_uri() . '/fonts/HelveticaNeueCyrRoman_1.css');
  wp_enqueue_style('HelveticaNeueCyrBold', get_template_directory_uri() . '/fonts/HelveticaNeueCyrBold.css');
  wp_enqueue_style('RobotoCondensedBold', get_template_directory_uri() . '/fonts/RobotoCondensedBold.css');
  wp_enqueue_style('HelveticaNeueCyrLight', get_template_directory_uri() . '/fonts/HelveticaNeueCyrLight.css');
  wp_enqueue_style('RobotoCondensedLight', get_template_directory_uri() . '/fonts/RobotoCondensedLight.css');
  wp_enqueue_style('HelveticaNeueCyrUltraLight', get_template_directory_uri() . '/fonts/HelveticaNeueCyrUltraLight.css');
  wp_enqueue_style('RobotoCondensedRegular', get_template_directory_uri() . '/fonts/RobotoCondensedRegular.css');
  wp_enqueue_style('HelveticaNeueCyrThin', get_template_directory_uri() . '/fonts/HelveticaNeueCyrThin.css');
  wp_enqueue_style('HelveticaNeueCyrRoman', get_template_directory_uri() . '/fonts/HelveticaNeueCyrRoman.css');
  wp_enqueue_style('HelveticaNeueCyrItalic', get_template_directory_uri() . '/fonts/HelveticaNeueCyrItalic.css');
  wp_enqueue_style('HelveticaNeueCyrLightItalic', get_template_directory_uri() . '/fonts/HelveticaNeueCyrLightItalic.css');
  wp_enqueue_style('Home', get_template_directory_uri() . '/fonts/style.css');
}

/**
 * загружаем стили и скрипты
 **/
add_action('wp_enqueue_scripts', 'load_style_script');

/**
 * меню
 **/
register_nav_menu('menu', 'Меню');

add_action('init', 'codex_book_init');


function custom_archive_query($query) {
  if ($query->is_archive()) {
    $query->set('post_status', array('future', 'publish'));
  }
  return $query;
}
add_filter('pre_get_posts', 'custom_archive_query');

function publish_future_posts_immediately($post_id, $post) {
  global $wpdb;
  if ($post->post_status == 'future') {
    $wpdb->update($wpdb->posts, array('post_status' => 'publish'), array('ID' => $post_id));
    wp_clear_scheduled_hook('publish_future_post', $post_id);
  }
}
add_action('save_post', 'publish_future_posts_immediately', 10, 2);

function isacustom_excerpt_length($length) {
  global $post;
  if ($post->post_type == 'post')
  return 32;
  else if ($post->post_type == 'products')
  return 65;
  else if ($post->post_type == 'testimonial')
  return 75;
  else
  return 80;
}
add_filter('excerpt_length', 'isacustom_excerpt_length');

function true_filter_by_date($where = '') {
  $firstDayNextMonth = date('Y-m-01', strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
  $firstDayThisMonth = date("Y-m-01");
  $date = get_field('date');
  $where .= " AND post_date >= '$firstDayThisMonth' AND post_date < ' $firstDayNextMonth'";
  return $where;
}

function true_filter_by_date_next($where = '') {
  $firstDayNextMonth = date('Y-m-01', strtotime(date('m', strtotime('+2 month')).'/01/'.date('Y').' 00:00:00'));
  $firstDayThisMonth = date('Y-m-01', strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
	$where .= " AND post_date >= '$firstDayThisMonth' AND post_date < ' $firstDayNextMonth'";
	return $where;
}

function true_filter_by_date_week($where = '') {
  $this_week1 = date ("Y-m-d", time() - (      date("N")-1) * 24*60*60);
  $this_week2 = date ("Y-m-d", time() - ( -6 + date("N")-1) * 24*60*60);
  $date = get_field('date');
  $where .= " AND post_date >= '$this_week1' AND post_date < ' $this_week2'";
  return $where;
}

function true_filter_by_date_next_week($where = '') {
  $next_week1 = date ("Y-m-d", time() - ( -7 + date("N")-1) * 24*60*60);
  $next_week2 = date ("Y-m-d", time() - (-13 + date("N")-1) * 24*60*60);
	$where .= " AND post_date >= '$next_week1 ' AND post_date < ' $next_week2'";
	return $where;
}

function true_filter_by_date_all_week($where = '') {
  $this_week1 = date ("Y-m-d", time() - (      date("N")-1) * 24*60*60);
  $next_week2 = date ("Y-m-d", time() - (-13 + date("N")-1) * 24*60*60);
	$where .= " AND post_date >= '$this_week1' AND post_date < ' $next_week2'";
	return $where;
}

function true_filter_by_date_all_week_next($where = '') {
  $this_week1 = date ("Y-m-d", time() - (      date("N")-1) * 24*60*60);
  $next_week2 = date ("Y-m-d", time() - (-13 + date("N")-1) * 24*60*60);
  $firstDayNextMonth = date('Y-m-01', strtotime(date('m', strtotime('+2 month')).'/01/'.date('Y').' 00:00:00'));
  $firstDayThisMonth = date('Y-m-01', strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
  $where .= " AND ((post_date >= '$this_week1' AND post_date < ' $next_week2'".") OR (post_date >= '$firstDayThisMonth' AND post_date < ' $firstDayNextMonth'))";
  return $where;
}

function true_filter_by_date_all_week_this($where = '') {
  $this_week1 = date ("Y-m-d", time() - (      date("N")-1) * 24*60*60);
  $next_week2 = date ("Y-m-d", time() - (-13 + date("N")-1) * 24*60*60);
  $firstDayNextMonth = date('Y-m-01', strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
  $firstDayThisMonth = date("Y-m-01");
  $where .= " AND ((post_date >= '$this_week1' AND post_date < ' $next_week2'".") OR (post_date >= '$firstDayThisMonth' AND post_date < ' $firstDayNextMonth'))";
  return $where;
}

function true_filter_by_date_1($where = '') {
  $this_week1 = date ("Y-m-d", time() - (      date("N")-1) * 24*60*60);
  $this_week2 = date ("Y-m-d", time() - ( -6 + date("N")-1) * 24*60*60);
  $firstDayNextMonth = date('Y-m-01', strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
  $firstDayThisMonth = date("Y-m-01");
  $where .= " AND ((post_date >= '$this_week1' AND post_date < ' $this_week2'".") OR (post_date >= '$firstDayThisMonth' AND post_date < ' $firstDayNextMonth'))";
  return $where;
}

function true_filter_by_date_2($where = '') {
  $this_week1 = date ("Y-m-d", time() - (      date("N")-1) * 24*60*60);
  $this_week2 = date ("Y-m-d", time() - ( -6 + date("N")-1) * 24*60*60);
  $firstDayNextMonth = date('Y-m-01', strtotime(date('m', strtotime('+2 month')).'/01/'.date('Y').' 00:00:00'));
  $firstDayThisMonth = date('Y-m-01', strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
  $where .= " AND ((post_date >= '$this_week1' AND post_date < ' $this_week2'".") OR (post_date >= '$firstDayThisMonth' AND post_date < ' $firstDayNextMonth'))";
  return $where;
}

function true_filter_by_date_3($where = '') {
  $next_week1 = date ("Y-m-d", time() - ( -7 + date("N")-1) * 24*60*60);
  $next_week2 = date ("Y-m-d", time() - (-13 + date("N")-1) * 24*60*60);
  $firstDayNextMonth = date('Y-m-01', strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
  $firstDayThisMonth = date("Y-m-01");
  $where .= " AND ((post_date >= '$next_week1' AND post_date < ' $next_week2'".") OR (post_date >= '$firstDayThisMonth' AND post_date < ' $firstDayNextMonth'))";
  return $where;
}

function true_filter_by_date_4($where = '') {
  $next_week1 = date ("Y-m-d", time() - ( -7 + date("N")-1) * 24*60*60);
  $next_week2 = date ("Y-m-d", time() - (-13 + date("N")-1) * 24*60*60);
  $firstDayNextMonth = date('Y-m-01', strtotime(date('m', strtotime('+2 month')).'/01/'.date('Y').' 00:00:00'));
  $firstDayThisMonth = date('Y-m-01', strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
  $where .= " AND ((post_date >= '$next_week1' AND post_date < ' $next_week2'".") OR (post_date >= '$firstDayThisMonth' AND post_date < ' $firstDayNextMonth'))";
	return $where;
}

function true_filter_by_date_all($where = '') {
  $firstDayNextMonth = date('Y-m-01', strtotime(date('m', strtotime('+2 month')).'/01/'.date('Y').' 00:00:00'));
  $firstDayThisMonth = date("Y-m-01");
  $where .= " AND post_date >= '$firstDayThisMonth' AND post_date < ' $firstDayNextMonth'";
  return $where;
}

/* чтобы вставить код php в статьях/страницах WordPress, поставьте шоркод: [exec]код[/exec] */
function exec_php($matches){
  eval('ob_start();'.$matches[1].'$inline_execute_output = ob_get_contents();ob_end_clean();');
  return $inline_execute_output;
}

function inline_php($content){
  $content = preg_replace_callback('/\[exec\]((.|\n)*?)\[\/exec\]/', 'exec_php', $content);
  $content = preg_replace('/\[exec off\]((.|\n)*?)\[\/exec\]/', '$1', $content);
  return $content;
}
add_filter('the_content', 'inline_php', 0);

function new_excerpt_length($length) {
  return 20;
}
add_filter('excerpt_length', 'new_excerpt_length');

function my_calendar($fill = array(), $cat) {
  $month_names = array("январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь");
  if (isset($_GET['y'])) $y = $_GET['y'];
  if (isset($_GET['m'])) $m = $_GET['m'];
  if (isset($_GET['date']) AND strstr($_GET['date'],"-")) list($y,$m) = explode("-",$_GET['date']);
  if (!isset($y) OR $y < 1970 OR $y > 2037) $y = date("Y");
  if (!isset($m) OR $m < 1 OR $m > 12) $m = date("m");
  $month_stamp = mktime(0, 0, 0, $m, 1, $y);
  $day_count = date("t", $month_stamp);
  $weekday = date("w", $month_stamp);
  if ($weekday == 0) $weekday = 7;
  $start =- ($weekday - 2);
  $last = ($day_count + $weekday - 1) % 7;
  if ($last == 0) $end = $day_count; else $end = $day_count + 7 - $last;
  $today = date("Y-m-d");
  $prev = date('?\m=m&\y=Y',mktime (0, 0, 0, $m - 1, 1, $y));
  $next = date('?\m=m&\y=Y',mktime (0, 0, 0, $m + 1, 1, $y));
  $i = 0; ?>
  <table border=1 cellspacing=0 cellpadding=2 width="100%" class="calendar">
    <tr>
      <td colspan=7>
     		<table width="100%" border=0 cellspacing=0 cellpadding=0>
	        <tr>
	         <!--<td align="left"><a href="<? //echo $prev ?>">&lt;&lt;&lt;</a></td>-->
	         <td align="center"><? echo $month_names[$m - 1], " ", $y ?></td>
	         <!--<td align="right"><a href="<? echo $next ?>">&gt;&gt;&gt;</a></td>-->
	        </tr>
     		</table>
      </td>
   	</tr>
   	<tr><td>Пн</td><td>Вт</td><td>Ср</td><td>Чт</td><td>Пт</td><td>Сб</td><td>Вс</td>
 		<tr> <?
   		for ($d = $start; $d <= $end; $d++) {
     		if (!($i++ % 7)) echo " <tr>\n";
       		$args = array(
						'posts_per_page' => -1,
						'cat' => $cat,
						'order' => 'ASC',
						'orderby' => 'meta_value_num',
						'meta_key' => 'date',
						'post_status' => 'any',
						'meta_query' => $meta_query_args);
       		$query = new WP_Query($args);
       		while ($query->have_posts()) {
						$categoryColor = false;
						$find = false;
						$query->the_post();
						$dateTemp = get_field('date');
						$dTemp = substr($dateTemp, 6);
						$mTemp = substr($dateTemp, 4, 2);
						$yTemp = substr($dateTemp, 0, 4);
         		if (($d == $dTemp) && ($m == $mTemp) && ($y == $yTemp)) {
							$find = true;
							$count = 0;
         			for ($i2 = 1; $i2 <= 6; $i2++) {
             		if (get_field('fl-type'.$i2)) $count++;
           		}
           		if ($count != 1) {
             		$categoryColor = 'category-more1';
           		} else {
								if (get_field('fl-type1')) $categoryColor = 'category-buh';
								if (get_field('fl-type2')) $categoryColor = 'category-ur';
								if (get_field('fl-type3')) $categoryColor = 'category-kadr';
								if (get_field('fl-type4')) $categoryColor = 'category-bud';
								if (get_field('fl-type5')) $categoryColor = 'category-gos';
								if (get_field('fl-type6')) $categoryColor = 'category-ruk';
                if (get_field('fl-type7')) $categoryColor = 'category-ped';
           		}
           		break;
         		}
       		} ?>
      		<td class="calendarTd <?php echo $categoryColor; ?>" align="center"> <?php
      			if ($find) { ?>
        			<a style="color: white; text-decoration: none;" href='<?php the_permalink(); ?>'> <?php
      			}
     				if ($d < 1 OR $d > $day_count) {
       				echo "&nbsp";
     				} else {
       				echo $d;
     				}
     				if ($find) {
       				echo "</a></td>\n";
     				} else {
       				echo "</td>\n";
     				}
     				if (!($i % 7))  echo " </tr>\n";
 			} ?>
	</table>
  <div class="clearfix filt-open">
    <h4>категория слушателей</h4>
  </div>
  <ul class="category">
    <li data-eq="0" <?php if (isset($_GET["eq0"])){ ?> class="active" <?php } ?>>
      <div class="category-buh"></div>
      <p>для бухгалтера</p>
    </li>
    <li data-eq="1" <?php if (isset($_GET["eq1"])){ ?> class="active" <?php } ?>>
      <div class="category-ur"></div>
      <p>для юриста</p>
    </li>
    <li data-eq="2" <?php if (isset($_GET["eq2"])){ ?> class="active" <?php } ?>>
      <div class="category-kadr"></div>
      <p>для кадровика</p>
    </li>
    <li data-eq="3" <?php if (isset($_GET["eq3"])){ ?> class="active" <?php } ?>>
      <div class="category-bud"></div>
      <p>для бюджетника</p>
    </li>
    <li data-eq="4" <?php if (isset($_GET["eq4"])){ ?> class="active" <?php } ?>>
      <div class="category-gos"></div>
      <p>для специалиста по госзакупкам</p>
    </li>
    <li data-eq="5" <?php if (isset($_GET["eq5"])){ ?> class="active" <?php } ?>>
      <div class="category-ruk"></div>
      <p>для руководителя</p>
    </li>
    <li data-eq="6" <?php if (isset($_GET["eq6"])){ ?> class="active" <?php } ?>>
      <div class="category-ped"></div>
      <p>для педагога</p>
    </li>
  </ul> <?php
}

function seminarOnCatalog() { ?>
  <div class="sem-list-semenar"
      data-eq0="<?php if (get_field('fl-type1')) { ?>active<?php } ?>"
      data-eq1="<?php if (get_field('fl-type2')) { ?>active<?php } ?>"
      data-eq2="<?php if (get_field('fl-type3')) { ?>active<?php } ?>"
      data-eq3="<?php if (get_field('fl-type4')) { ?>active<?php } ?>"
      data-eq4="<?php if (get_field('fl-type5')) { ?>active<?php } ?>"
      data-eq5="<?php if (get_field('fl-type6')) { ?>active<?php } ?>"
      data-eq6="<?php if (get_field('fl-type7')) { ?>active<?php } ?>"
      data-eq6="<?php if (get_field('city1')) { ?>active<?php } ?>"
      data-eq7="<?php if (get_field('city2')) { ?>active<?php } ?>"
      data-eq8="<?php if (get_field('city3')) { ?>active<?php } ?>"
      data-eq9="<?php if (get_field('city4')) { ?>active<?php } ?>"
      data-eq10="<?php if (get_field('city5')) { ?>active<?php } ?>"
      data-eq11="<?php if (get_field('city6')) { ?>active<?php } ?>"> <?php
    if (get_field('type1')) { ?>
      <p class="sem-list-semenar-type type1 clearfix">
        <span>Обучение работе с Системой КонсультантПлюс</span>
      </p> <?php
    }
    if (get_field('type2')) { ?>
      <p class="sem-list-semenar-type type2 clearfix">
        <span>Семинар</span>
      </p> <?php
    }
    if (get_field('type3')) { ?>
      <p class="sem-list-semenar-type type3 clearfix">
        <span>Дополнительное профессиональное образование</span>
      </p> <?php
    }
    if (get_field('vebinar')) { ?>
      <p class="sem-list-semenar-type vebinar clearfix">
        <span>Вебинар</span>
      </p> <?php
    }
    if (get_field('training')) { ?>
      <p class="sem-list-semenar-type training clearfix">
        <span>Тренинг</span>
      </p> <?php
    } ?>
    <div class="sem-list-semenar-description clearfix"> <?php
      if (get_field('attached')) { ?>
        <h2 class="welcomeLector"><?php the_field('welcome'); ?></h2> <?php
      } ?>
      <div class="sem-list-semenar-description-left"> <?php
        if (get_field('lector_img')) {
          $photo = get_field('lector_img'); ?>
          <img src="<?php echo $photo['url']; ?>" alt="<?php echo $photo['alt']; ?>" class="lector-photo" /> <?php
        }
        if (get_field('lector_img2')) {
          $photo2 = get_field('lector_img2'); ?>
          <img src="<?php echo $photo2['url']; ?>" alt="<?php echo $photo2['alt']; ?>" class="lector-photo" /> <?php
        }
        if (get_field('date_catalog')) { ?>
          <p class="sem-list-semenar-description-block1-date font-size-small"> <?php
        } else { ?>
          <p class="sem-list-semenar-description-block1-date"> <?php
        }
          if (!get_field('unDate')) {
            if (get_field('date_catalog')) {
              the_field('date_catalog');
            } else {
              $t3Date = get_field('date');
              $t3Date = substr($t3Date, 6);
              if ($t3Date[0] == "0") {
                echo $t3Date[1];
              } else {
                echo $t3Date;
              }
            }
          } ?>
        </p>
      </div>
      <div class="sem-list-semenar-description-block1">
        <div class="sem-list-semenar-description-full"> <?php
          if (get_field('lector_name')) {
            if ((!get_field('attached')) || ((get_field('attached')) && ((get_field('lector_img')) || (get_field('lector_img2'))))) { ?>
              <p class="sem-list-semenar-description-full-shot">
                <span class="sem-list-semenar-description-full-shot-lect">
                  лектор: <?php the_field('lector_name'); ?>
                </span>
              </p> <?php
            }
          } ?>
          <p class="sem-list-semenar-description-full-name">
            <a href="<?php echo get_permalink(); ?>"> <?php the_title(); ?></a>
          </p>
          <p class="sem-list-semenar-description-full-text">
            <?php the_field('shot'); ?>
          </p>
        </div>
        <a class="sem-list-semenar-bt" href="<?php echo get_permalink(); ?>">Заявка на участие</a>
      </div>
      <div class="sem-list-semenar-description-block"> <?php
        if (!get_field('attached')) { ?>
          <div class="sem-list-semenar-description-place">
            <p class="sem-list-semenar-description-place-title">Место проведения</p> <?php
            if (get_field('vebinar')) { ?>
              <p class="sem-list-semenar-description-place-text">Персональный ПК</p> <?php
            } else { ?>
              <p class="sem-list-semenar-description-place-text"> <?php
                if (get_field('city1')) { ?>
                  г. Ростов-на-Дону<?php
                } ?>
              </p>
              <p class="sem-list-semenar-description-place-text"> <?php
                if (get_field('city2')) { ?>
                  г. Таганрог<?php
                } ?>
              </p>
              <p class="sem-list-semenar-description-place-text"> <?php
                if (get_field('city3')) { ?>
                  г. Волгодонск<?php
                } ?>
              </p>
              <p class="sem-list-semenar-description-place-text"> <?php
                if (get_field('city4')) { ?>
                  г. Каменск-Шахтинский<?php
                } ?>
              </p>
              <p class="sem-list-semenar-description-place-text"> <?php
                if (get_field('city5')) { ?>
                  г. Сальск<?php
                } ?>
              </p>
              <p class="sem-list-semenar-description-place-text"> <?php
                if (get_field('city6')) { ?>
                  г. Миллерово<?php
                } ?>
              </p> <?php
            } ?>
          </div> <?php
        } ?>
        <div class="sem-list-semenar-description-price">
          <p class="sem-list-semenar-description-price-title">Стоимость участия</p>
          <p class="sem-list-semenar-description-price-text"> <?php
            if ((get_field('type2')) || (get_field('type3')) || (get_field('vebinar'))) {
              if (get_field('priceFirst')) {
                echo "от ".get_field('priceFirst').checkFreePrice(get_field('priceFirst'))."<br/>";
              }
              if (get_field('priceLast')) {
                echo "до ".get_field('priceLast').checkFreePrice(get_field('priceLast'));
              }
            }
            if ((get_field('type1')) || (get_field('training'))) {
              echo get_field('price').checkFreePrice(get_field('price'));
            } ?>
          </p>
        </div>
      </div>
    </div>
  </div> <?php
}

function checkFreePrice ($price) {
  if (strnatcasecmp($price, "бесплатно")) {
    return "  рублей";
  }
}

function checkFreePriceShort ($price) {
  if (strnatcasecmp($price, "бесплатно")) {
    return "  руб.";
  }
}

function seminarsCatalog($categoryOfSeminar) {
  $trans = array("01" => "январь",
                 "02" => "февраль",
                 "03" => "март",
                 "04" => "апрель",
                 "05" => "май",
                 "06" => "июнь",
                 "07" => "июль",
                 "08" => "август",
                 "09" => "сентябрь",
                 "10" => "октябрь",
                 "11" => "ноябрь",
                 "12" => "декабрь",
                 "1" => "январь",
                 "2" => "февраль",
                 "3" => "март",
                 "4" => "апрель",
                 "5" => "май",
                 "6" => "июнь",
                 "7" => "июль",
                 "8" => "август",
                 "9" => "сентябрь",
                 "10" => "октябрь",
                 "11" => "ноябрь",
                 "12" => "декабрь");
  $today_m = date("m");
  $today = date("Ymd");
  $flag_dec = true;
  $timeCheck = "09:00";
  $timeNow = date('H:i');
  if (count($_GET) != 0) { ?>
    <script>
      (function($) {
        $(document).ready(function(){
          CreatTag();
          TegEvent();
        })
      })(jQuery);
    </script> <?php
  } ?>
  <div class="clearfix main-semenar">
    <section class="semenar-list clearfix">
      <section class="semenar-list-content">
        <ul class="teg-block clearfix"></ul>
        <section class="sem-list"> <?php
          $args = array(
            'posts_per_page' => -1,
            'cat' => $categoryOfSeminar,
            'order' => 'ASC',
            'post_status' => 'publish');
          $query = new WP_Query($args);
          while ($query->have_posts()) {
            $query->the_post();
            if (get_field('attached')) { ?>
              <p class="sem-list-month"> <?php
                $date = get_field('date');
                $m = substr($date, 4, 2);
                $data_m  = strtr($m, $trans);
                echo mb_convert_case($data_m, MB_CASE_LOWER, "UTF-8"); ?>
              </p> <?php
              seminarOnCatalog();
            }
          }
          wp_reset_postdata();
          $start = $today_m;
          while ($today_m < 14) {
            $data_m = strtr($today_m, $trans); ?>
            <p class="sem-list-month"><?php echo $data_m; ?></p> <?php
            global $post;
            if (isset($_GET["eq9"])) { $eq9 = array('key' => 'city1', 'value' => '1', 'compare' => '='); }
              else { $eq9 = array(); }
            if (isset($_GET["eq10"])) { $eq10 = array('key' => 'city2', 'value' => '1', 'compare' => '='); }
              else { $eq10 = array(); }
            if (isset($_GET["eq11"])) { $eq11 = array('key' => 'city3', 'value' => '1', 'compare' => '='); }
              else { $eq11 = array(); }
            if (isset($_GET["eq12"])) { $eq12 = array('key' => 'city4', 'value' => '1', 'compare' => '='); }
              else { $eq12 = array(); }
            if (isset($_GET["eq13"])) { $eq13 = array('key' => 'city5', 'value' => '1', 'compare' => '='); }
              else { $eq13 = array(); }
            if (isset($_GET["eq14"])) { $eq14 = array('key' => 'city6', 'value' => '1', 'compare' => '='); }
              else { $eq14 = array(); }
            $block1 = array('relation' => 'OR', $eq9, $eq10, $eq11, $eq12, $eq13, $eq14);
            if (isset($_GET["eq0"])) { $eq0 = array('key' => 'fl-type1', 'value' => '1', 'compare' => '='); }
              else { $eq0 = array(); }
            if (isset($_GET["eq1"])) { $eq1 = array('key' => 'fl-type2', 'value' => '1', 'compare' => '='); }
              else { $eq1 = array(); }
            if (isset($_GET["eq2"])) { $eq2 = array('key' => 'fl-type3', 'value' => '1', 'compare' => '='); }
              else { $eq2 = array(); }
            if (isset($_GET["eq3"])) { $eq3 = array('key' => 'fl-type4', 'value' => '1', 'compare' => '='); }
              else { $eq3 = array(); }
            if (isset($_GET["eq4"])) { $eq4 = array('key' => 'fl-type5', 'value' => '1', 'compare' => '='); }
              else { $eq4 = array(); }
            if (isset($_GET["eq5"])) { $eq5 = array('key' => 'fl-type6', 'value' => '1', 'compare' => '='); }
              else { $eq5 = array(); }
            if (isset($_GET["eq6"])) { $eq6 = array('key' => 'fl-type7', 'value' => '1', 'compare' => '='); }
              else { $eq6 = array(); }
            $block2 = array('relation' => 'OR', $eq0, $eq1, $eq2, $eq3, $eq4, $eq5, $eq6);
            $meta_query_args = array('relation' => 'AND', $block1, $block2);
            $args = array(
              'posts_per_page' => -1,
              'cat' => $categoryOfSeminar,
              'order' => 'ASC',
              'orderby' => 'meta_value_num',
              'meta_key' => 'date',
              'post_status' => 'publish',
              'meta_query' => $meta_query_args);
            $query = new WP_Query($args);
            while ($query->have_posts()) {
              $query->the_post();
              $date = get_field('date');
              if (((strtotime($today) < strtotime($date))) || ((strtotime($today) == strtotime($date)) && ($timeNow < $timeCheck))) {
                $m = substr($date, 4, 2);
                if (($m == $today_m) && (!get_field('attached'))) {
                  seminarOnCatalog();
                }
              }
            }
            wp_reset_postdata();
            if (date("m") == 12 && $today_m == 12 && $flag_dec) {
              $flag_dec = false;
              $today_m = 1;
            } else {
              $today_m++;
              if ($today_m == $start) {
                $today_m = 14;
              }
            }
          }
          $args = array(
            'posts_per_page' => -1,
            'cat' => $categoryOfSeminar,
            'order' => 'DESC',
            'orderby' => 'meta_value_num',
          	'meta_key' => 'date',
            'post_status' => 'publish',
            'meta_query' => $meta_query_args);
          $query = new WP_Query($args); ?>
          <p class="sem-list-month"><?php echo "по мере формирования" ?></p> <?php
          while ($query->have_posts()) {
            $query->the_post();
            if (!get_field('date') && (!get_field('attached'))) {
              $m = 13;
              seminarOnCatalog();
            }
            wp_reset_postdata();
            $today_m++;
          } ?>
        </section>
      </section>
    </section>
    <section class="filt clearfix">
      <section class="filt-container clearfix">
        <section class="filt-type">
          <div id="filt-type-block" class="filt-type-block filt-type-block2">
            <div id="filt-type-block" class="filt-type-block filt-type-block2"> <?php
              my_calendar(array(date("Y-m-d")), $categoryOfSeminar); ?>
            </div>
          <div class="filt-type-block filt-type-block3">
            <div class="clearfix filt-open">
              <h4>место проведения</h4>
            </div>
            <ul>
              <li data-eq="9" <?php if (isset($_GET["eq9"])){ ?> class="active" <?php } ?>><p>Ростов-на-Дону</p></li>
              <li data-eq="10" <?php if (isset($_GET["eq10"])){ ?> class="active" <?php } ?>><p>Таганрог</p></li>
              <li data-eq="11" <?php if (isset($_GET["eq11"])){ ?> class="active" <?php } ?>><p>Волгодонск</p></li>
              <li data-eq="12" <?php if (isset($_GET["eq12"])){ ?> class="active" <?php } ?>><p>Каменск-Шахтинский</p></li>
              <li data-eq="13" <?php if (isset($_GET["eq13"])){ ?> class="active" <?php } ?>><p>Сальск</p></li>
              <li data-eq="14" <?php if (isset($_GET["eq14"])){ ?> class="active" <?php } ?>><p>Миллерово</p></li>
              <li data-eq="15" <?php if (isset($_GET["eq15"])){ ?> class="active" <?php } ?>><p>дома/на рабочем месте(вебинар)</p></li>
            </ul>
          </div>
        </section>
      </section>
    </section>
  </div> <?php
}

function listOnMain($categ) {
  $today_m = date("m");
  $today_d = date("d");
  $data_m  = strtr( $today_m, $trans);
  $today = date("d.m.Y");
  $timeNow = date('H:i');
  $timeCheck = "09:00";
  $flag_dec = true;
  $trans = array("01" => "январь",
                 "02" => "февраль",
                 "03" => "март",
                 "04" => "апрель",
                 "05" => "май",
                 "06" => "июнь",
                 "07" => "июль",
                 "08" => "август",
                 "09" => "сентябрь",
                 "10" => "октябрь",
                 "11" => "ноябрь",
                 "12" => "декабрь",
                 "1" => "январь",
                 "2" => "февраль",
                 "3" => "март",
                 "4" => "апрель",
                 "5" => "май",
                 "6" => "июнь",
                 "7" => "июль",
                 "8" => "август",
                 "9" => "сентябрь",
                 "10" => "октябрь",
                 "11" => "ноябрь",
                 "12" => "декабрь",
                 "13" => "по мере формирования");
  $countPosts = 5;
  global $post;
  $args = array('numberposts' => -1,
                'category' => $categ,
                'post_status' => 'publish');
  $myposts = get_posts($args);
  $countPostsWithDate = 0;
  $countPostsWithoutDate = 0;
  foreach ($myposts as $post) {
    if ((get_field('date')) && (strtotime(get_field('date')) > strtotime($today))) {
      $countPostsWithDate++;
    } else if (!get_field('date')) {
      $countPostsWithoutDate++;
    }
  }
  if ($countPostsWithDate > $countPosts) {
    $numberPosts = $countPosts;
    $numberPostsWithoutDates = 0;
  } else {
    $numberPosts = $countPostsWithDate;
    $numberPostsWithoutDates = $countPosts - $numberPosts;
    if ($numberPostsWithoutDates > $countPostsWithoutDate) {
      $numberPostsWithoutDates = $countPostsWithoutDate;
    }
  }
  wp_reset_postdata(); ?>
  <div class="seminar-data"> <?php
    $i = 0;
    $today_m = date("m");
    $flag_dec = true;
    while ($today_m <= 13) {
      $data_m = strtr($today_m, $trans); ?>
      <div class="calend"></div> <?php
      global $post;
      $args = array(
        'posts_per_page' => -1,
        'cat' => $categ,
        'order' => 'ASC',
        'orderby' => 'meta_value_num',
        'meta_key' => 'date',
        'post_status' => 'publish');
      $query = new WP_Query($args);
      while ($query->have_posts()) {
        $query->the_post();
        $date = get_field('date');
        if (((strtotime($today) < strtotime($date))) || ((strtotime($today) == strtotime($date)) && ($timeNow < $timeCheck))) {
          if ($i < $numberPosts) {
            $m = substr($date, 4, 2);
            if ($m == $today_m) { ?>
              <p class="seminar-data-day"> <?php
                if (!get_field('unDate')) {
                  $t3Date = get_field('date');
                  $t3Date = substr($t3Date, 6);
                  if ($t3Date[0] == "0") {
                    echo $t3Date[1];
                  } else {
                    echo $t3Date;
                  }
                } ?>
              </p> <?php
              $i++;
            }
          } else {
            wp_reset_postdata();
          }
        }
      }
      wp_reset_postdata();
      if (date("m") == 12 && $today_m == 12 && $flag_dec) {
        $flag_dec = false;
        $today_m = 1;
      } else {
        $today_m++;
      }
    }
    if ($numberPostsWithoutDates > 0) {
      $args = array(
        'posts_per_page' => $numberPostsWithoutDates,
        'cat' => $categ,
        'order' => 'ASC',
        'orderby' => 'meta_value_num',
        'meta_key' => 'date',
        'post_status' => 'publish');
      $query = new WP_Query($args);
      while ($query->have_posts()) {
        $query->the_post();
        if (!get_field('date')) { ?>
          <p class="seminar-data-day"></p> <?php
          wp_reset_postdata();
          $today_m++;
        }
      }
    } ?>
  </div>
  <div class="seminar-name"> <?php
    $i = 0;
    $today_m = date("m");
    $flag_dec = true;
    while ($today_m <= 13) {
      $data_m = strtr($today_m, $trans); ?>
      <p class="seminar-mounth"> <?php
        echo $data_m; ?>
      </p> <?php
      global $post;
      $args = array(
        'posts_per_page' => -1,
        'cat' => $categ,
        'order' => 'ASC',
        'orderby' => 'meta_value_num',
        'meta_key' => 'date',
        'post_status' => 'publish');
      $query = new WP_Query($args);
      while ($query->have_posts()) {
        $query->the_post();
        $d = substr($date, 6, 2);
        $date = get_field('date');
        if (((strtotime($today) < strtotime($date))) || ((strtotime($today) == strtotime($date)) && ($timeNow < $timeCheck))) {
          if ($i < $numberPosts) {
            $m = substr($date, 4, 2);
            if ($m == $today_m) { ?>
              <div class="seminar-name-block">
                <a href="<?php echo get_permalink(); ?>">
                  <h3> <?php the_title(); ?></h3>
                </a>
                <p> <?php
                  $string = substr(get_field('shot'), 0, 130);
                  $string = rtrim($string, "!,.-");
                  if (strlen(get_field('shot')) >= 130) {
                    $string = substr($string, 0, strrpos($string, ' '));
                    echo $string."… ";
                  } else {
                    echo $string;
                  } ?>
                </p>
              </div> <?php
              $i++;
            }
          } else {
            wp_reset_postdata();
          }
        }
      }
      wp_reset_postdata();
      if (date("m") == 12 && $today_m == 12 && $flag_dec) {
        $flag_dec = false;
        $today_m = 1;
      } else {
        $today_m++;
      }
    }
    if ($numberPostsWithoutDates > 0) {
    	if (get_field('training')) {
    		$args = array(
          'posts_per_page' => $numberPostsWithoutDates,
          'cat' => $categ,
          'order' => 'DESC',
          'orderby' => 'meta_value_num',
          'meta_key' => 'numberOrder');
    	} else {
        $args = array(
          'posts_per_page' => $numberPostsWithoutDates,
          'cat' => $categ,
          'order' => 'ASC',
          'orderby' => 'meta_value_num',
          'meta_key' => 'date',
          'post_status' => 'publish');
    	}
      $query = new WP_Query($args);
      while ($query->have_posts()) {
        $query->the_post();
        if ((!get_field('date'))) { ?>
          <div class="seminar-name-block">
            <a href="<?php echo get_permalink(); ?>">
              <h3> <?php the_title(); ?></h3>
            </a>
            <p> <?php
              $string = substr(get_field('shot'), 0, 130);
              $string = rtrim($string, "!,.-");
              if (strlen(get_field('shot')) >= 130) {
                $string = substr($string, 0, strrpos($string, ' '));
                echo $string."… ";
              } else {
                echo $string;
              } ?>
            </p>
          </div> <?php
          wp_reset_postdata();
          $today_m++;
        }
      }
    } ?>
  </div> <?php
}

function listOnMain_advanced($categ, $meta_key, $order) {
  $today_m = date("m");
  $today_d = date("d");
  $data_m  = strtr( $today_m, $trans);
  $today = date("d.m.Y");
  $timeNow = date('H:i');
  $timeCheck = "09:00";
  $flag_dec = true;
  $trans = array("01" => "январь",
                 "02" => "февраль",
                 "03" => "март",
                 "04" => "апрель",
                 "05" => "май",
                 "06" => "июнь",
                 "07" => "июль",
                 "08" => "август",
                 "09" => "сентябрь",
                 "10" => "октябрь",
                 "11" => "ноябрь",
                 "12" => "декабрь",
                 "1" => "январь",
                 "2" => "февраль",
                 "3" => "март",
                 "4" => "апрель",
                 "5" => "май",
                 "6" => "июнь",
                 "7" => "июль",
                 "8" => "август",
                 "9" => "сентябрь",
                 "10" => "октябрь",
                 "11" => "ноябрь",
                 "12" => "декабрь",
                 "13" => "по мере формирования");
  $countPosts = 5;
  global $post;
  $args = array('numberposts' => -1,
                'category' => $categ,
                'post_status' => 'publish');
  $myposts = get_posts($args);
  $countPostsWithDate = 0;
  $countPostsWithoutDate = 0;
  foreach ($myposts as $post) {
    if ((get_field('date')) && (strtotime(get_field('date')) > strtotime($today))) {
      $countPostsWithDate++;
    } else if (!get_field('date')) {
      $countPostsWithoutDate++;
    }
  }
  if ($countPostsWithDate > $countPosts) {
    $numberPosts = $countPosts;
    $numberPostsWithoutDates = 0;
  } else {
    $numberPosts = $countPostsWithDate;
    $numberPostsWithoutDates = $countPosts - $numberPosts;
    if ($numberPostsWithoutDates > $countPostsWithoutDate) {
      $numberPostsWithoutDates = $countPostsWithoutDate;
    }
  }
  wp_reset_postdata(); ?>
  <div class="seminar-data"> <?php
    $i = 0;
    $today_m = date("m");
    $flag_dec = true;
    while ($today_m <= 13) {
      $data_m = strtr($today_m, $trans); ?>
      <div class="calend"></div> <?php
      global $post;
      $args = array(
        'posts_per_page' => -1,
        'cat' => $categ,
        'order' => $order,
        'orderby' => 'meta_value_num',
        'meta_key' => $meta_key,
        'post_status' => 'publish');
      $query = new WP_Query($args);
      while ($query->have_posts()) {
        $query->the_post();
        $date = get_field('date');
        if (((strtotime($today) < strtotime($date))) || ((strtotime($today) == strtotime($date)) && ($timeNow < $timeCheck))) {
          if ($i < $numberPosts) {
            $m = substr($date, 4, 2);
            if ($m == $today_m) { ?>
              <p class="seminar-data-day"> <?php
                if (!get_field('unDate')) {
                  $t3Date = get_field('date');
                  $t3Date = substr($t3Date, 6);
                  if ($t3Date[0] == "0") {
                    echo $t3Date[1];
                  } else {
                    echo $t3Date;
                  }
                } ?>
              </p> <?php
              $i++;
            }
          } else {
            wp_reset_postdata();
          }
        }
      }
      wp_reset_postdata();
      if (date("m") == 12 && $today_m == 12 && $flag_dec) {
        $flag_dec = false;
        $today_m = 1;
      } else {
        $today_m++;
      }
    }
    if ($numberPostsWithoutDates > 0) {
      $args = array(
        'posts_per_page' => $numberPostsWithoutDates,
        'cat' => $categ,
        'order' => $order,
        'orderby' => 'meta_value_num',
        'meta_key' => $meta_key,
        'post_status' => 'publish');
      $query = new WP_Query($args);
      while ($query->have_posts()) {
        $query->the_post();
        if (!get_field('date')) { ?>
          <p class="seminar-data-day"></p> <?php
          wp_reset_postdata();
          $today_m++;
        }
      }
    } ?>
  </div>
  <div class="seminar-name"> <?php
    $i = 0;
    $today_m = date("m");
    $flag_dec = true;
    while ($today_m <= 13) {
      $data_m = strtr($today_m, $trans); ?>
      <p class="seminar-mounth"> <?php
        echo $data_m; ?>
      </p> <?php
      global $post;
      $args = array(
        'posts_per_page' => -1,
        'cat' => $categ,
        'order' => $order,
        'orderby' => 'meta_value_num',
        'meta_key' => $meta_key,
        'post_status' => 'publish');
      $query = new WP_Query($args);
      while ($query->have_posts()) {
        $query->the_post();
        $d = substr($date, 6, 2);
        $date = get_field('date');
        if (((strtotime($today) < strtotime($date))) || ((strtotime($today) == strtotime($date)) && ($timeNow < $timeCheck))) {
          if ($i < $numberPosts) {
            $m = substr($date, 4, 2);
            if ($m == $today_m) { ?>
              <div class="seminar-name-block">
                <a href="<?php echo get_permalink(); ?>">
                  <h3> <?php the_title(); ?></h3>
                </a>
                <p> <?php
                  $string = substr(get_field('shot'), 0, 130);
                  $string = rtrim($string, "!,.-");
                  if (strlen(get_field('shot')) >= 130) {
                    $string = substr($string, 0, strrpos($string, ' '));
                    echo $string."… ";
                  } else {
                    echo $string;
                  } ?>
                </p>
              </div> <?php
              $i++;
            }
          } else {
            wp_reset_postdata();
          }
        }
      }
      wp_reset_postdata();
      if (date("m") == 12 && $today_m == 12 && $flag_dec) {
        $flag_dec = false;
        $today_m = 1;
      } else {
        $today_m++;
      }
    }
    if ($numberPostsWithoutDates > 0) {
      $args = array(
        'posts_per_page' => $numberPostsWithoutDates,
        'cat' => $categ,
        'order' => $order,
        'orderby' => 'meta_value_num',
        'meta_key' => $meta_key,
        'post_status' => 'publish');
      $query = new WP_Query($args);
      while ($query->have_posts()) {
        $query->the_post();
        if ((!get_field('date'))) { ?>
          <div class="seminar-name-block">
            <a href="<?php echo get_permalink(); ?>">
              <h3> <?php the_title(); ?></h3>
            </a>
            <p> <?php
              $string = substr(get_field('shot'), 0, 130);
              $string = rtrim($string, "!,.-");
              if (strlen(get_field('shot')) >= 130) {
                $string = substr($string, 0, strrpos($string, ' '));
                echo $string."… ";
              } else {
                echo $string;
              } ?>
            </p>
          </div> <?php
          wp_reset_postdata();
          $today_m++;
        }
      }
    } ?>
  </div> <?php
}

  /*
  add_action('wpcf7_mail_sent', 'your_wpcf7_mail_sent_function');

  function your_wpcf7_mail_sent_function($contact_form) {

    define('CRM_HOST', '264.bitrix24.ru');
    define('CRM_PORT', '443');
    define('CRM_PATH', '/crm/configs/import/lead.php');
    define('CRM_LOGIN', 'zhukovvp@compeng.ru');
    define('CRM_PASSWORD', 'iduled774');

    $title = $contact_form->title;
    $posted_data = $contact_form->posted_data;
    if (($title == 'Contact_Form_Edu_Attach') || ($title == 'Contact_Form_Training_Attach') || ($title == 'Contact_Form_Edu') || ($title == 'Contact_Form_main')) {
      $submission = WPCF7_Submission::get_instance();
      $posted_data = $submission->get_posted_data();

      $fio = explode(" ", $posted_data['text-name']);
      $firstName = $fio[1];
      $lastName = $fio[0];
      $secondName = $fio[2];
      $email = $posted_data['text-email'];
      $phone = $posted_data['text-phone'];
      $org = $posted_data['text-org'];
      if (isset($posted_data['menu-spec'])) {
        $post = "Специализация: ".$posted_data['menu-spec'];
      }
      $comment = "<a href='".$posted_data['text-url']."'>".$posted_data['text-url']."</a><br>";
      $comment .= $posted_data['textarea-comment']."<br>";
      $bonuse = $posted_data['checkbox-bonuse'];
      $comment .= $bonuse[0];

      $postData = array(
        'TITLE' => 'Заявка с seminar-rostov',
        'NAME' => $firstName,
        'LAST_NAME' => $lastName,
        'SECOND_NAME' => $secondName,
        'EMAIL_WORK' => $email,
        'PHONE_WORK' => $phone,
        'POST' => $post,
        'COMPANY_TITLE' => $org,
        'COMMENTS' => $comment,
      );

      if (defined('CRM_AUTH')) {
        $postData['AUTH'] = CRM_AUTH;
      } else {
        $postData['LOGIN'] = CRM_LOGIN;
        $postData['PASSWORD'] = CRM_PASSWORD;
      }

      $fp = fsockopen("ssl://".CRM_HOST, CRM_PORT, $errno, $errstr, 30);
      if ($fp) {
        $strPostData = '';
        foreach ($postData as $key => $value)
          $strPostData .= ($strPostData == '' ? '' : '&').$key.'='.urlencode($value);

        $str = "POST ".CRM_PATH." HTTP/1.0\r\n";
        $str .= "Host: ".CRM_HOST."\r\n";
        $str .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $str .= "Content-Length: ".strlen($strPostData)."\r\n";
        $str .= "Connection: close\r\n\r\n";

        $str .= $strPostData;
        fwrite($fp, $str);

        $result = '';
        while (!feof($fp)) {
          $result .= fgets($fp, 128);
        }
        fclose($fp);
        $response = explode("\r\n\r\n", $result);

        $output = '<pre>'.print_r($response[1], 1).'</pre>';
      } else {
        echo 'Connection Failed! '.$errstr.' ('.$errno.')';
      }
    }
  }
  */

?>
