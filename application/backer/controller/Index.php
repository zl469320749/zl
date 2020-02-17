<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/20
 * Time: 15:07
 */

namespace app\backer\controller;


use app\common\model\Articles;
use think\Controller;
use think\Db;

class Index extends Controller
{

    public function index(){

        return $this->fetch('index');

    }

    public function home(){

        return $this->fetch('home');

    }

}