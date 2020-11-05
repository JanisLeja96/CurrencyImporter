<html>
<head>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <th>Name</th>
        <th>Rate</th>
    </tr>
    <?php foreach ($data as $currency):?>
        <tr>
            <?php echo "<td>{$currency['name']}</td>";?>
            <?php echo "<td>{$currency['rate']}</td>";?>
        </tr>
    <?php endforeach;?>
</table>


</body>
</html>