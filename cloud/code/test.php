<?php
  $data = file_get_contents('http://argusingenieria.com/frozen/reporter.php?request=161101;1;1');
  $obj = json_decode($data);
  print $obj->{'valor'};
?>
