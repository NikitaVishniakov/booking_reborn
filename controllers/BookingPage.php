<?php
namespace controllers;
use models\{Booking, Payment, Services};
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 21.06.17
 * Time: 20:29
 */
class BookingPage extends \core\base\Controller
{
    public function indexAction(){
        global $link;

        $result = Booking::getPropertyList('booking',$this->route['id']);

        if(!$result){
            header("location:/admin");
        }

        $this->setVariablesForView(
          array(
              'arrResult'=> $result
          )
        );
    }


    public function confirmBookingAction(){
        global $link;
        $this->layout= false;

        $update = $link->query("UPDATE booking SET isConfirmed = 1 WHERE id={$this->route['id']}");
        header('location:'. $_SERVER['HTTP_REFERER']);
    }

    public function cancelConfirmationAction(){
        $this->layout= false;

        if(Booking::update('booking', array('isConfirmed' => 0), $this->route['id'])){
            header('location:'. $_SERVER['HTTP_REFERER']);
        }
    }


    public function deleteAction(){
        $this->layout = false;
        global $link;
        if(isAdmin()){
            $delete = $link->query("DELETE FROM booking WHERE id = {$this->route['id']}");
        }
        header('location:'. $_SERVER['HTTP_REFERER']);
    }


    public function cancelAction(){
        global $link;
        $this->layout = false;
        $link->query("UPDATE booking SET canceled = 1 WHERE  id = {$this->route['id']}");
        header('location:/admin/booking_page/'.$this->route['id']);
    }


    public function reestablishBookingAction(){
        global $link;
        $this->layout = false;
        $link->query("UPDATE booking SET canceled = 0 WHERE  id = {$this->route['id']}");
        header('location:/admin/booking_page/'.$this->route['id']);
    }


    public function confirmAction(){
        $this->layout = false;

        $data = array(
            'checkIn' => 1
        );
        if(Booking::update('booking', $data, $this->route['id'])){
            header('location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function addServiceAction(){
        $this->layout = false;

        $item = Services::getPropertyList('services_list', $_POST['services']['name']);
        $_POST['services']['price'] = $_POST['services']['quantity'] * $item['price'];
        $_POST['services']['name'] = $item['name'];

        if(Services::save('services', $_POST['services'])){
            header('location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function addProlongationHoursAction(){
        $this->layout = false;

        if(isset($_GET['AJAX'])){
            $hoursStart = strtotime($_GET['hoursStart']);
            $hoursEnd = strtotime($_GET['hoursEnd']);
            $price = $_GET['price'];
            $hours = ($hoursEnd - $hoursStart)/3600;
            $total_price = $price * $hours;
            $arr = ['price' => $total_price, 'hours' => $hours];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($arr,JSON_UNESCAPED_UNICODE);
        }
        else{
            if(Services::save('services', $_POST['prolongation'])){
                Booking::update('booking', array('prolongation_hours' => 1), $_POST['prolongation']['b_id']);
                header('location:' . $_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function deleteServiceAction(){
        $this->layout = false;
        $groups = array('main');

//        accessControl($groups);

        if(Services::delete('services', $this->route['id'])){
            header('location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function getDaysCountAction(){
        $this->layout = false;
        $days = getDaysCount($_GET['dateEnd'], $_GET['dateStart']);
        $price = str_replace( ' ', '', $_GET['price']);
        $total = intval($price) * $days;
        echo separateThousands($total);
    }

    public function saveInfoAction(){
        $this->layout = false;
        $_POST['bookingInfo']['breakfast'] = isset($_POST['bookingInfo']['breakfast']) ? 1 : 0;
        if(Booking::safetyUpdate($_POST['bookingInfo'], $this->route['id'])){
            header('location:' . $_SERVER['HTTP_REFERER']);
        }
    }



    public function editCommentAction(){
        $this->layout = false;
        $_POST['comment']['comment'] = inputControl($_POST['comment']['comment']);
        if(Booking::update('booking', $_POST['comment'], $this->route['id'])){
            header('location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    public  function saveAmountAction(){
        $this->layout = false;

        if(Booking::update('booking', $_POST['priceChange'], $this->route['id'])){
            header('location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function changeTotalPriceAction(){
        $this->layout = false;
        $arrPrice['price'] = str_replace(' ', '', $_GET['price']);
        $arrPrice['amount'] = str_replace(' ', '', $_GET['total']);
        $arrPrice['id'] = $_GET['id'];

        if(Booking::update('booking', $arrPrice)){
            return true;
        }
    }

    public function countTotalPriceAction(){
        $this->layout = false;
        $arrPrice['price'] = str_replace(' ', '', $_GET['price']);
        $arrPrice['amount'] = str_replace(' ', '', $_GET['total']);
        $arrPrice['id'] = $_GET['id'];
        $dates = Booking::getPropertyList('booking', $arrPrice['id'], array('dateStart', 'dateEnd',));
        $days = getDaysCount($dates['dateEnd'], $dates['dateStart']);

        if($_GET['action'] == 'total_price_val'){
            $arrPrice['price'] = round($arrPrice['amount'] / $days, 0);
//            Booking::update('booking', $arrPrice);
            echo $arrPrice['price'];
        }
        else{
            $arrPrice['amount'] = intval($arrPrice['price']) * intval($days);
            echo $arrPrice['amount'];
        }
    }

    public function getDepositAction(){
        global $link;
        $this->layout = false;
        $link->query("UPDATE booking SET deposit = 1 WHERE  id = {$this->route['id']}");
        header('location:/admin/booking_page/'.$this->route['id']);
    }

    public function returnDepositAction(){
        global $link;
        $this->layout = false;
        $link->query("UPDATE booking SET deposit = 0 WHERE  id = {$this->route['id']}");
        header('location:/admin/booking_page/'.$this->route['id']);
    }

    public function getDepositGatesAction(){
        global $link;
        $this->layout = false;
        $link->query("UPDATE booking SET depositGates = 1 WHERE  id = {$this->route['id']}");
        header('location:/admin/booking_page/'.$this->route['id']);
    }

    public function returnDepositGatesAction(){
        global $link;
        $this->layout = false;
        $link->query("UPDATE booking SET depositGates = 0 WHERE  id = {$this->route['id']}");
        header('location:/admin/booking_page/'.$this->route['id']);
    }

}