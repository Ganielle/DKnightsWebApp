<?php

include 'model.php';

$model = new Model();

$rows = $model->fetch_yrs();

echo json_encode($rows);