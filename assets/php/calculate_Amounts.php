<?php
$lateDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastDueDate)) . " + ".$daysTillLate." days"));

if($today >= $lateDate){  //User is past due and needs to pay late fee
    $howManyMonthsLate = diffrenceOfMonth($today,$lateDate);
    if($howManyMonthsLate == 0){
        $nextDueDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastDueDate)) . "1 month "));
        $balance = $rent - (-$amountPaid + $lastBalance);
        if ($balance < 0){  //There is extra from what they paid to be put toward the late fee
            $fee = $latefee + $lastLateFeeOwed;
            $lateFeeForRecord = $fee;
            $fee += $balance;
            $balance = '0';
            if ($fee < 0){  // Add extra after paying late fee back to amount
                $balance = $fee;
                $fee = '0';
            }
//            echo "Next Due Date: $nextDueDate balance: $balance LateFee: $fee ForRecordLateFee: $lateFeeForRecord";
        }
        else{
            $lateFeeForRecord = $latefee + $lastLateFeeOwed;
            $fee = $latefee;
//            echo "Next Due Date: $nextDueDate balance: $balance LateFee: $fee ForRecordLateFee: $lateFeeForRecord";
        }
    }
    else{ // way overdue and need to calculate everything from last time paid
        $nextDueDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastDueDate)) . ($howManyMonthsLate + 1)." month "));
        $balance = (($howManyMonthsLate + 1) * $rent) + ($amountPaid + $lastBalance);
        $fee = (($howManyMonthsLate + 1) * $latefee)+ $lastLateFeeOwed;
        $lateFeeForRecord = $fee;
        if ($balance < 0) {  //There is extra from what they paid to be put toward the late fee
            $fee += $balance;
            $balance = '0';
            if ($fee < 0){  // Add extra after paying late fee back to amount
                $balance = $fee;
                $fee = '0';
            }
        }
//        echo "Next Due Date: $nextDueDate balance: $balance LateFee: $fee ForRecordLateFee: $lateFeeForRecord";
    }
}
else {  //User is perfect here just pay rent and add late fee from before
    $calcHowManyMonthsToPayFor = floor(-$amountPaid/$rent); //If they pay ahead gets extra amount
    $balance = ($amountPaid + $lastBalance) + ($calcHowManyMonthsToPayFor * $rent);
    if ($balance > $rent){  //if they pay under the amount owed they go here
        $fee = $lastLateFeeOwed;
        $lateFeeForRecord = $fee;
        $nextDueDate = $lastDueDate;
//        echo "Next Due Date: $nextDueDate balance: $balance LateFee: $fee ForRecordLateFee: $lateFeeForRecord";
    }
    else{ //they payed either the amount  or more of the amount due
        $nextDueDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastDueDate)) . "$calcHowManyMonthsToPayFor month "));
        $fee = $lastLateFeeOwed;
        $lateFeeForRecord = $fee;
        if ($balance < 0) {  //There is extra from what they paid to be put toward the late fee
            $fee += $balance;
            $balance = '0';
            if ($fee < 0){  // Add extra after paying late fee back to amount
                $balance = $fee;
                $fee = '0';
            }
        }
//        echo "Next Due Date: $nextDueDate balance: $balance LateFee: $fee ForRecordLateFee: $lateFeeForRecord";
    }
}
function diffrenceOfMonth($date1,$date2){
    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);
    $interval = $date2->diff($date1);
    return (($interval->format('%y') * 12) + $interval->format('%m'));
}
?>