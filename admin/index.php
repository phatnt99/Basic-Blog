<?php
require_once 'core/init.php';
require_once 'includes/header.php';

if($user)
{
    require_once 'templates/sidebar-des.php';
    require_once 'templates/content-des.php';
} else
{
    require_once 'templates/sigin-des.php';
}


require_once 'includes/footer.php';
?>