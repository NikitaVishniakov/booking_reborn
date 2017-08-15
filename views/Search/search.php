<?php

        if(isset($_GET['search'])){
            $find = inputControl($_GET['search']);
            $result = \models\Booking::getElementList('booking', array('id', 'guestName', 'booker','roomNum', 'dateStart', 'dateEnd', 'canceled'), "guestName LIKE '%{$find}%' OR booker LIKE '%{$find}%'");
        }

        $result = $result ?? 0;

require_once TEMPLATES . "search.php";
        ?>