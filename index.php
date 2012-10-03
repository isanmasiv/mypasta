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
/******************************************************************
  My Pasta by 日本の笑顔 [^__^] aka anonkz
  tnx to kurkuma, ojab
  exUSSR, 2012
******************************************************************/
  $pastaserver='http://localhost';
  $pastadir='pasta/';
  $pastaname='My Pasta Service';
  $pastaver='2';
  $pastahead='<h1><a href="'.$pastaserver.$_SERVER['PHP_SELF'].'">'.$pastaname.'</a></h1>';
  $pastafoot='<a href="mailto:'.$_SERVER['SERVER_ADMIN'].'">Написать админу</a>';

  function generate_code($number) {
    $out = '';
    $codes = '123456789ABCDEFGHJKMNPQRSTUVWXYZ';
    while ($number > 31) {
      $key = $number % 32;
      $number = floor($number / 32) - 1;
      $out = $codes{$key}.$out;
    }
    return $codes{((int) $number)}.$out;
  }
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
  $view=$_SERVER['QUERY_STRING'];
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
    if (file_exists($pastadir.$view) && preg_match('~^[0-9A-Z]+$~', $view)) {
      $file_handle = fopen($pastadir.$view, 'r');
      $filedata = '';
      $filecols = 0;
      while (!feof($file_handle)) {
        $filedata .= fgets($file_handle);
        $filecols++;
      }
      fclose($file_handle);
      echo '<p><b>Ваша паста:</b></p><p><textarea rows="'.($filecols<20?20:$filecols).'" cols="50" readonly>'.htmlspecialchars($filedata).'</textarea></p>';
      echo '<p>Ссылка на пасту: <input name="nick" type="text" size="40" value="'.$pastaserver.$_SERVER['REQUEST_URI'].'" readonly><p>';
    } else {
      echo '<p><b>Ваша паста не найдена.</b></p>';
    }
  } elseif ($pastatext!='' && $view=='') {
    microtime(true);
    $curfile=generate_code(count(scandir($pastadir))-1);
    $file_handle = fopen($pastadir.$curfile,'w');
    fwrite($file_handle,$pastatext);
    fclose($file_handle);
    echo '<p><b>Паста добавлена.</b></p>';
    echo '<p><a href="'.$pastaserver.$_SERVER['REQUEST_URI'].'?'.$curfile.'">Продолжить.</p>';
  }
  if (isset($pastafoot) && $pastafoot!='')
    echo $pastafoot;
?>

</body>
</html>