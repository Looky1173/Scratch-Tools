<?php

//Set theme
if(isset($_COOKIE['halfmoon_preferredMode'])){
    if($_COOKIE['halfmoon_preferredMode'] == 'dark-mode'){
        echo 'class="dark-mode"';
    }
}