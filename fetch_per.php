<?php

include 'model.php';

$model = new Model();

$rows = $model->fetch_mth();

echo json_encode($rows);