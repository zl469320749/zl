<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/27
 * Time: 16:09
 */

namespace app\backer\controller;


use app\common\model\Users;
use think\App;
use think\Controller;

class Login extends Controller
{

    private $users;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->users = new Users();
    }

    public function index(){

        if($this->request->isPost()){
            //用户名
            $username = $this->request->post('title');
            if(!$username){
                $this->error('用户名为空');
            }
            $userpass = $this->request->post('password');
            if(!$userpass){
                $this->error('密码为空');
            }
            $pass = md5($userpass);
        }

        return $this->fetch('login');

    }

}