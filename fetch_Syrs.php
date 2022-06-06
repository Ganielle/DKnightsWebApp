<?php

include 'model.php';

$model = new Model();

$rows = $model->fetch_Syrs();

echo json_encode($rows);