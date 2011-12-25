<?php

require_once ("zn_file.php");

try
{
	$file = new ZN_File();													// без указания относительного пути
	$file = new ZN_File("/home/site1/public_html");							// с указанием относительного пути

	if ($file->is_file(".htaccess"))										// относительный путь в указаниях файла
	{
		echo ".htaccess существует";
	}

	echo $file->get("css/default.css");										// отобразить файл /home/site1/public_html/css/default.css
	echo $file->put("admin/.htaccess", "deny from all");					// прописать строку в файле /home/site1/public_html/admin/.htaccess

	$images = $file->ls("/home/site1/public_html/img");						// показать все файлы и папки в папке 
	$images_png = $file->ls("img", "file", "png");							// показать все файлы с расширением png

	$file->cp("upload", "/home/site1/arhiv");								// копировать папку upload
	$file->cp(".htaccess", ".htaccess_old");								// сделать архив файла .htaccess
	$file->cp("/home/user/favicon.ico", ".");								// копировать favicon.ico в папку /home/site1/public_html

	$file->mv("admin", "admin_secret");										// переименовать папку admin в admin_secret

	$file->rm("/home/site1/public_html/test");								// удалить папку test

	$file->chmod("upload", 0777);											// назначить рекурсивно права 777

	$file->size("/home/site1/public_html");									// определить размер всего сайта

	$file->upload($_FILES['image']['tmp_name'], "upload/" . $_FILES['image']['name']); // закачать файл через форму
	
	$file->set_path("/home/site1/www");										// выбрать папку для chroot
	$file->chroot_enable();													// включить chroot
	echo $file->get("/home/site1/log/error.log");							// выдаст ошибку т.к. за пределами корневой папки
	$file->chroot_disable();												// отключить chroot

	$file->download("/home/site1/log/access.log");							// скачать файл access.log
	$file->download("/home/site1/log/error.log", "/home/user/error.log");	// скачать файл error.log в локальную папку

	$dirs_and_files = array
		(
		'/home/site1/www/img',
		'/home/site1/log/access.log',
		'favicon.ico',
		'/home/site1/www/upload'
	);
	$file->zip($dirs_and_files, "main.zip");								// Скачать файлы и папки zip-архивом (окно загрузки)
	$file->zip("/home/site1/log", null, "/arhiv/" . date("Y-m-d", time()) . ".zip");	// Скачать логи в zip-архив
}
catch (Exception $e)
{
	echo $e->getMessage();
}
?>