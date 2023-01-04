<?php
    require_once 'vendor/autoload.php';
    use Dompdf\Dompdf;

    $conn = new PDO('mysql:host=localhost;dbname=magazin','root','antonia');
    
    $sql = 'SELECT * FROM PRODUCTS';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $i=1;
    $html='<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDF</title>
    </head>
    <style>
        h2{
            font-family:Verdana, Geneva, Tahoma, sans-serif;
            text-align:center;
        }
        table{
            font-family: Arial, Helvetica, sans-serif;
            border-collapse:collapse;
            width:100%;
        }
        td,th{
            border: 1px solid #444;
            padding:8px;
            text-align:left;
        }
    
    </style>
    <body>
        <h2>Products<h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>';
    foreach($rows as $row){
        $html.='<tr>
        <td>'.$i.'</td>
        <td>'.$row["name"].'</td>
        <td>'.$row["price"].'</td>
        <td>'.$row["stock"].'</td>
        </tr>';
        $i++;
    }
    $html.=' </tbody>
    </table>
</body>
</html>';

$dompdf= new Dompdf;
$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');
$dompdf->render();
$dompdf->stream('products.pdf',['Attachment'=> 0] );
?>


       