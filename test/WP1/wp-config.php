<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'WP1');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'e!&1i 3H*MU&KizMl$G$, TihH#*dSq&aqrsi*<Qv,/W110^u8}I6Lb2JQd.KdB+');
define('SECURE_AUTH_KEY',  'qOeN8/QP4Q9}u__^Jvk,e$47Ahc5aCRW=m{s~]|Vjvp^w=Z(U^Px_*L:lK?H-,g}');
define('LOGGED_IN_KEY',    '-~t1.s )(Wo%x:ZdfyS<+UVPwLa}QQq(_95(F7KzA6njw0=6(wr7]THsr(x![qA=');
define('NONCE_KEY',        'OM8(DHgBT#7Zf1P7+0.n04~y*/iH[kR*l>&bhV-b[M95Lhv*9wEG/vpV@aS!VKQ{');
define('AUTH_SALT',        'm]cM`z<G,e+$.]ucR2)j!MPk]ryA-f0HIjzhkbTmALM_6BmJXpDAO=JopLlpZ1<;');
define('SECURE_AUTH_SALT', '5]J_.iN*wX-2)PJZ3!u>bJq~3L|+HMUb8=:c[$sUI=_l!X+p fXjvTo@kwQK>o^g');
define('LOGGED_IN_SALT',   'I5fA3TFH$>7TlYU/Z3%@+scC(nQHq&A9qV7[FM(ubUjURZhPp{zMDz{=(*8gy`w]');
define('NONCE_SALT',       'FzZG#+*O6Z#!zS%Y!XhANhuo?~ko~t.+7!c^VqKL+ReWJ?N=S/4LH,OHH+3a;Jsh');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
