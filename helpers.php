<?php

// view ထဲက  file တွေကို  eg::view(dashboard.php) လို့ခေါ်သုံး လို့ရ အောင်ရေးထားတာ;
function view($file , $data = null){
    if($data){
        extract($data);
    }
    require_once("view/$file");

}