<?php
class JConfig {
	public $offline = '0';
	public $offline_message = 'Сайт закрыт на техническое обслуживание.<br /> Пожалуйста, зайдите позже.';
	public $sitename = 'VINmd.com - проверка VIN-номера автомобиля';
	public $editor = 'jckeditor';
	public $list_limit = '20';
	public $access = '1';
	public $debug = '0';
	public $debug_lang = '0';
	public $dbtype = 'mysqli';
	//public $host = '';
	//public $user = 'viteg_vinmd';
	//public $password = 'G9xwJBn5';
	//public $db = 'viteg_vinmd';
	public $host = 'localhost';
	public $user = 'root';
	public $password = 'serjcom';
	public $db = 'vinmd';

	public $dbprefix = 'uhj73_';
	public $live_site = '';
	public $secret = 'OOamwtdbT2TpeHgi';
	public $gzip = '0';
	public $error_reporting = 'default';
	public $helpurl = 'http://help.joomla.org/proxy/index.php?option=com_help&keyref=Help{major}{minor}:{keyref}';
	public $ftp_host = '127.0.0.1';
	public $ftp_port = '21';
	public $ftp_user = 'admin';
	public $ftp_pass = '688536';
	public $ftp_root = '';
	public $ftp_enable = '0';
	public $offset = 'UTC';
	public $offset_user = 'UTC';
	public $mailer = 'mail';
	public $mailfrom = 'Vit729@gmail.com';
	public $fromname = 'VINmd.com';
	public $sendmail = '/usr/sbin/sendmail';
	public $smtpauth = '0';
	public $smtpuser = '';
	public $smtppass = '';
	public $smtphost = 'localhost';
	public $smtpsecure = 'none';
	public $smtpport = '25';
	public $caching = '0';
	public $cache_handler = 'file';
	public $cachetime = '15';
	public $MetaDesc = 'Проверка vin-номера автомобиля. Фотографии и отчёты по VIN-коду. Информация об авто по VIN. ';
	public $MetaKeys = 'Проверить авто,в молдове,вин-код,vin,проверить vin,фото по vin,код,авто,история автомобиля,база данных,code,расшифровка,кода,авторынок,автоаукционы,отчет сша,пробить,карфакс,авточек,манхейм,
carfax,autocheck,автобазар,информация,америка,USA,машин,бесплатно,copart,vin код,vin код автомобиля';
	public $MetaTitle = '1';
	public $MetaAuthor = '1';
	public $sef = '1';
	public $sef_rewrite = '1';
	public $sef_suffix = '0';
	public $unicodeslugs = '0';
	public $feed_limit = '10';
	public $log_path = '/home/viteg/vinmd/log';
	public $tmp_path = '/home/viteg/vinmd/tmp';
	public $lifetime = '150';
	public $session_handler = 'database';
	public $MetaRights = '';
	public $sitename_pagetitles = '0';
	public $force_ssl = '0';
	public $feed_email = 'author';
	public $cookie_domain = '';
	public $cookie_path = '/';
	public $memcache_persist = '1';
	public $memcache_compress = '1';
	public $memcache_server_host = 'localhost';
	public $memcache_server_port = '11211';
	public $display_offline_message = '0';
	public $robots = '';
	public $offline_image = '';
	public $captcha = '0';
	public $MetaVersion = '0';
}