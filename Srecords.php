<?php

include 'Smodel.php';

$model = new Model();

if (isset($_POST['Syrs'])  && !empty($_POST['Syrs'])) {
    
    $Syrs = $_POST['Syrs'];
    $rows = $model->fetch_filter($Syrs);
} else {
    $rows = $model->fetch();
}

echo json_encode($rows);