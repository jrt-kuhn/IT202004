<?php
$response = [
    "status"=>200,
    "data"=>[
        "x"=>100,
        "y" => 50,
        "speed"=>7,
        "sideLength"=>60
    ]
    ];
echo json_encode($response);
?>
