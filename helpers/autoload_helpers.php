<?php

$files = [
    'url_helper',
    'flashdata_helper',
    'setting_helper'
];


foreach ($files as $file) {
    require_once("{$file}.php");
}

unset($files);
unset($file);
