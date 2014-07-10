<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Pretend
    |--------------------------------------------------------------------------
    |
    | Use this switch to turn hipchat notifications on and off. Defaults to true.
    */
    'pretend' => true,

    /*
    |--------------------------------------------------------------------------
    | Notify
    |--------------------------------------------------------------------------
    |
    | Use this switch to warn room members of new notification or not. Defaults to false.
    */
    'notify' => false,

    /*
    |--------------------------------------------------------------------------
    | Rooms
    |--------------------------------------------------------------------------
    |
    | Specify hipchat rooms in which to post notifications.
    |
    */
    'default' => 'main',

    'rooms' => array(

        'main' => array(
            'room_id'    => 'your-room-id',
            'auth_token' => 'your-room-token',
        ),

    ),

    /*
    |--------------------------------------------------------------------------
    | Color
    |--------------------------------------------------------------------------
    |
    | Specify the color for the notifications background. Valid values are
    | 'yellow', 'red', 'green', 'purple', 'gray' and 'random'. Default to 'gray'
    |
    */
   
    'color' => 'gray',
);
