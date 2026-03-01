<?php
include_once('base.php');
/// Redirect_url - https://site.com/redirect.php?url=chat-team.com
if (isset($_GET['url'])){
$url = $_GET['url'];
header('Location: https://'.$url.'');
}
?>