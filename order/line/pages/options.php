<?php
$options = [];
if (isset($_GET['product'])) :
    $options = getProductOptions($_GET['product']);
endif;

foreach ($options AS $cati => $catv) :
    
endforeach;