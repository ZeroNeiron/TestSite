<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link href="lightbox.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="demo.css" />
<script type="text/javascript" src="script.js"></script>

 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <title>Галерея jQuery засобами PHP</title>
 
</head>
<body>
<div id="container">
 <div id="heading"> <!-- заголовок -->
 <h1>A cool jQuery gallery</h1>
 </div>
 <div id="Images"> 
 <?php
 
	$папка = "img";
 // 1)Перевіряємо чи існує імя
	if(isset($_POST['download'])) 
{ 
 if($_FILES['FILE']['name'])
 {	
		 // 2)Перевіряємо розмір файлу
	 if($_FILES['FILE']['size'] != 0 AND
		$_FILES['FILE']['size']<=802400)
		 {
		 	$whitelist = array(".movie"); 

  			 $error = true;
  
   //Проверяем разрешение файла
		   foreach  ($whitelist as  $item) {
		        if(preg_match("/$item\$/i",$_FILES['FILE']['name'])) $error = false;
		   }

  if($error) die("Ошибка,&nbsp; Вы можете загружать только movie "); 
		 // 3)Перевірка чи завантажився файл на сервер
			 if(is_uploaded_file($_FILES['FILE']['tmp_name']))
			{

			 // 4)Переміщаємо завантажений файл в необхідну папку $папка
					 if(move_uploaded_file($_FILES['FILE']['tmp_name'],
					 $папка."/".basename($_FILES['FILE']['name'])))
					 {
					 //Виводимо повідомлення, що файл опрацьовано і завантажено
					 echo 'Файл '.basename($_FILES['FILE']['name']).' був успішнозавантажений в '.$папка;
					 }
					 else {echo 'Виникла помилка при переміщенні файла впапку'.$папка;}
					 }
			 else {echo 'Виникла помилка при завантаженні файлу на сервер';}
					 }
		 else {echo 'Розмір файлу не повинен перевищувати 800Кб';}
					 }
	else {echo 'Файл повинен мати назву';} 
}
 echo '<form action="index.php" method="post"
enctype="multipart/form-data">';
echo 'Файл: <input type="file" name="FILE" size="30" />';
echo '<input name="url" type="hidden" value="files">';
echo '<input name="download" type="submit" value="Завантажити">';
echo '</form>'; 


$directory = 'img'; //папка з картинками
$allowed_types=array('jpg','jpeg','gif','png'); //допустимі типи
$file_parts=array();
$ext='';
$title='';
$i=0;
//пробуємо відкрити папку
$dir_handle = @opendir($directory) or die("Сталася помилка при відкритті зображень із папки!");
while ($file = readdir($dir_handle)) //перевіряємо файли в папці
{
 if($file=='.' || $file == '..') continue; //пропускаємо посилання на поточну і батьківську папки
 $file_parts = explode('.',$file); //розбиваємо назву файлу на частини через крапку
 $ext = strtolower(array_pop($file_parts)); //визначаємо розширення файлу
 $title = implode('.',$file_parts); // назва файлу
 $title = htmlspecialchars($title); // перетворення назви в htmlбезпечний вигляд

 $nomargin='';

 if(in_array($ext,$allowed_types)) //якщо розширення допустиме
 {
  // останнє зображення в рядку отримує css клас 'nomargin'
 	if(($i+1)%4==0) $nomargin='nomargin'; // останнє зображення в
 echo '
 <div class="pic '.$nomargin.'"
style="background:url('.$directory.'/'.$file.') no-repeat 50% 50%;">
 <a data-lightbox="lbox" href="' .$directory .  '/'.$file.'" title="'.$title.'"
target="_blank">'.$title.'</a>
 </div>';
  $i++; //номер зображення
 }
}
closedir($dir_handle); //закриваємо папку
?>
<h1></h1>

<script src="lightbox-plus-jquery.min.js"></script>
</body>
</html>