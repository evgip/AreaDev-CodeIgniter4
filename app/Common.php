<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 * https://github.com/stanley-eires/business-marketer/blob/867535ae88dbdff12ef466c735c2f229d7dd18dc/app/Common.php
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 
 if (! function_exists('set_message')) {
     function set_message($status, $title, $message)
     {
         $notification_body = "
        <div class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='15000' data-autohide='true' style='min-width:250px'>
            <div class='toast-header bg-{$status}'>
                <strong class='mr-auto'>$title</strong>
                <small>".date('H:ia')."</small>
                <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'><span>&times;</span></button>
            </div>
            <div class='toast-body'>
                $message
            </div>
        </div>
        ";
         session()->setFlashdata('notification', $notification_body);
     }
 } */
 
 
function set_message($message)
{
    echo "<div class='yes-mess'>$message</div>";
}