<?php

if (is_array($view_scripts)) {
    foreach ($view_scripts as $script) {
        echo "<script src='{$script}'></script>";
    }
}

if (is_string($view_scripts)) {
    echo "<script src='{$view_scripts}'></script>";
}
