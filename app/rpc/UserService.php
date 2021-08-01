<?php
/**
 * Created by PhpStorm.
 * User: zpw
 * Date: 2021/8/1
 * Time: 17:51
 */

namespace app\rpc;


class UserService
{

      public function index()
      {
            return [
                'name'=>'zpw',
                'age'=>28,
                'money'=>10000,
            ];
      }

}//class end