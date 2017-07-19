<?php
/**
 * auth.php
 *
 * @author Jan Fitz <jan@janfitz.cz>
 * @link
 */

/*
*   HTTP authentication
*/
if ( !isset($_SERVER['PHP_AUTH_USER']) ) {
  header('WWW-Authenticate: Basic realm="You Shall Not Pass"');
  header('HTTP/1.0 401 Unauthorized');
  exit;
}
else {
  if ( $_SERVER['PHP_AUTH_USER'] == 'fuel' && $_SERVER['PHP_AUTH_PW'] == 'app' ) {
    ;
  } else {
    echo "Wrong password!";
  }
}
?>
