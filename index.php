<?php
/******************************************************************
           DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                   Version 2, December 2004

Copyright (C) 2004 Sam Hocevar
 14 rue de Plaisance, 75014 Paris, France
Everyone is permitted to copy and distribute verbatim or modified
copies of this license document, and changing it is allowed as long
as the name is changed.

           DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

0. You just DO WHAT THE FUCK YOU WANT TO.
******************************************************************/
  $pastaserver='http://localhost';
  $pastadir='pasta/';
  $pastaname='My Pasta Service';
  $pastaver='0.1';
  $pastahead='<a href="'.$pastaserver.$_SERVER['PHP_SELF'].'"><h1>'.$pastaname.'</h1></a>';
  $pastafoot='<a href="mailto:'.$_SERVER['SERVER_ADMIN'].'">Написать админу</a>';
?>
<html>
<head>
  <title><?php
  echo $pastaname;
?>
</title>
</head>
<body>
<?php
  $view=isset($_GET['view']) ? (string)$_GET['view'] : '';
  $pastatext=isset($_POST['pastatext']) ? (string)$_POST['pastatext'] : '';
  if (isset($pastahead) && $pastahead!='')
    echo $pastahead;

  if ($view=='' && $pastatext=='') {
    echo '<p><b>Введите вашу пасту:</b></p>
<form method="post">
  <p><textarea id="pastatext" rows="20" cols="50" name="pastatext"></textarea></p>
  <p><input type="submit" value="Отправить"></p>
</form>';
  } elseif ($view!='') {
    if (file_exists($pastadir.$view)) {
      $file_handle = fopen($pastadir.$view, 'r');
      $filedata = '';
      $filecols = 0;
      while (!feof($file_handle)) {
        $filedata .= fgets($file_handle);
        $filecols++;
      }
      fclose($file_handle);
      echo '<p><b>Ваша паста:</b></p><p><textarea rows="'.($filecols<20?20:$filecols).'" cols="50" readonly>'.$filedata.'</textarea></p>';
      echo '<p>Ссылка на пасту: <input name="nick" type="text" size="40" value="'.$pastaserver.$_SERVER['REQUEST_URI'].'" readonly><p>';
    } else {
      echo '<p><b>Ваша паста не найдена.</b></p>';
    }
  } elseif ($pastatext!='' && $view=='') {
    $curfile=strtotime('now');
    $file_handle = fopen($pastadir.$curfile,'w');
    fwrite($file_handle,$pastatext);
    fclose($file_handle);
    echo '<p><b>Паста добавлена.</b></p>';
    echo '<p><a href="'.$pastaserver.$_SERVER['REQUEST_URI'].'?view='.$curfile.'">Продолжить.</p>';
  }
  if (isset($pastafoot) && $pastafoot!='')
    echo $pastafoot;
?>

</body>
</html>