<?php
function sanitize($data)
{
$data = trim($data);
if(get_magic_quotes_gpc())
{
$data = stripslashes($data);
}
$data = mysql_real_escape_string($data);

return $data;
}

?>