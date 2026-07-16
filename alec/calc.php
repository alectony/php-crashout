<?php
    $num1 = 10;
    $num2 = 20;
    $num3 = 30;
    $num4 = 40;

    $add = $num1 + $num2;
    $sub = $num3 - $num2;
    $mul = $num1 * $num4;
    $div = $num4 / $num2;
    $mod = $num1 % $num2;
    $total = $add + $sub + $mul + $div;
    $avg = $total / 4;

    echo"The sum of $num1 and $num2 is $add <br>";
    echo"The difference between $num3 and $num2 is $sub <br>";
    echo"The product of $num1 and $num4 is $mul <br>";
    echo"The division of $num4 by $num2 is $div <br>";
    echo"The total of all results is $total <br>";
    echo"The average of all results is $avg";
?>
