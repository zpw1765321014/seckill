<?php
/**
 * Created by PhpStorm.
 * User: zpw
 * Date: 2021/8/1
 * Time: 17:51
 */

namespace App\rpc;

/**
 * rpc 对应的user 服务
 * Class UserService
 * @package App\rpc
 */
class UserService
{

      public function index($id)
      {

            return [
                'name'=>'zpw',
                'age'=>28,
                'money'=>10000,
                'id'   => $id,
            ];
      }

}//class end