<?php  
include("header.php");
//    prolongationOptions()dcs
$month = 5;
$returns = getGroupsCategoryTotal($month)
?>
<pre>
    <?php print_r($returns); ?>
</pre>
<?php
    include("footer.php");
?>
