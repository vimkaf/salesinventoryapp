<?php

foreach($view_fragment_paths as $path){
    if(file_exists($path)){
        require_once($path);
    }
}
