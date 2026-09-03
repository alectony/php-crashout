
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Salary Calculator</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background:#f4f6f9;
            margin:0;
            padding:30px;
        }

        .container{
            width:800px;
            margin:auto;
            background:#fff;
            padding:25px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,.2);
        }

        h2{
            text-align:center;
            color:#0d47a1;
        }

        label{
            font-weight:bold;
        }

        input{
            width:100%;
            padding:10px;
            margin-top:5px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:5px;
            box-sizing:border-box;
        }

        button{
            width:100%;
            padding:12px;
            background:#0d47a1;
            color:white;
            border:none;
            border-radius:5px;
            font-size:16px;
            cursor:pointer;
        }

        button:hover{
            background:#1565c0;
        }

        table{
            width:100%;
            margin-top:20px;
            border-collapse:collapse;
        }

        table, th, td{
            border:1px solid #ccc;
        }

        th{
            background:#0d47a1;
            color:white;
            padding:10px;
        }

        td{
            padding:10px;
        }
    </style>
</head>
<body>

<div class="container">

<h2>Employee Salary Calculator</h2>

<form method="POST">

    <label>Employee Name</label>
    <input type="text" name="name" required>

    <label>Basic Salary</label>
    <input type="number" name="basic" required>

    <label>Overtime Hours</label>
    <input type="number" name="hours" required>

    <label>Overtime Rate (per hour)</label>
    <input type="number" name="rate" required>

    <button type="submit" name="compute">
        Calculate Salary
    </button>

</form>



<?php


    if (isset($_POST['compute']) && ($_POST['name']) && ($_POST['basic']) && ($_POST['hours']) && ($_POST['rate']))
    {
        $name = $_POST['name'];
        $basic = $_POST['basic'];
        $hours = $_POST['hours'];
        $rate = $_POST['rate'];

        $overtime_pay = $hours * $rate;
        $gross_salary = $basic + $overtime_pay;
        if ($gross_salary >= 50000)
        {
            $bonus = 5000;
        }
        else if ($gross_salary >= 30000)
        {
            $bonus = 2500;
        }
        else
        {
            $bonus = 1000;
        }
        if ($gross_salary >= 50000)
        {
            $tax_deduction = $gross_salary * 0.15;
        }
        else if ($gross_salary >= 30000)
        {
            $tax_deduction = $gross_salary * 0.10;
        }
        else
        {
            $tax_deduction = $gross_salary * 0.05;
        }
        $net_salary = $gross_salary + $bonus - $tax_deduction;
?> 

<table>

<tr>
    <th colspan="2">Salary Summary</th>
</tr>

<tr>
    <td>Employee Name</td>
    <td><?php echo $name; ?></td>
</tr>

<tr>
    <td>Basic Salary</td>
    <td>₱<?php echo number_format($basic, 2); ?></td>
</tr>

<tr>
    <td>Overtime Pay</td>
    <td>₱<?php echo number_format($overtime_pay, 2); ?></td>
</tr>

<tr>
    <td>Gross Salary</td>
    <td>₱<?php echo number_format($gross_salary, 2); ?></td>
</tr>

<tr>
    <td>Bonus</td>
    <td>₱<?php echo number_format($bonus, 2); ?></td>
</tr>

<tr>
    <td>Tax Deduction</td>
    <td>₱<?php echo number_format($tax_deduction, 2); ?></td>
</tr>

<tr>
    <td><strong>Net Salary</strong></td>
    <td><strong>₱<?php echo number_format($net_salary, 2); ?></strong></td>
</tr>

</table>


</div>

<?php

    }

    else
    {
        echo "<p>Please fill in the form and click 'Calculate Salary' to see the results.</p>";
    }

?>





</body>
</html>