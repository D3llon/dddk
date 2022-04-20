<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | If you wish to extend the approval models with your own custom model,
    | you'll need to specify your models here. This is particularly useful
    | if you need to configure your models with UUID's as primary keys for
    | example.
    |
    */

    'models' => [
      'modification' => \App\Models\Modification::class,
      'approval'     => \App\Models\Approval::class,
      'disapproval'  => \App\Models\Disapproval::class,
    ],

];
