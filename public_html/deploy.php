<?php
exec('/usr/bin/git fetch origin master', $op, $rv);
print_r($op);
print_r($rv);
exec('/usr/bin/git reset --hard origin/master', $op, $rv);
print_r($op);
print_r($rv);
?>