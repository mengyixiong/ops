<?php

namespace App\Http\Controllers;


class ChatController extends BaseController
{
   public function send()
   {
       sleep(2);
       return $this->succOk();
   }
}
