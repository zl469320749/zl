<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/22
 * Time: 11:05
 */

namespace app\backer\controller;


use app\common\model\Articles;
use think\App;
use think\Controller;

class Article extends Controller
{

    private $articles;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->articles = new Articles();
    }

    public function index(){

        $data = $this->articles->select();
      /*  $list = Articles::order('id', 'desc')->paginate(2);
                $page = $list->render();
                $this->fetch('article_list', [
                    'list'=>$list,
                    'page'=>$page,
                    'data'=>$data
                ]);*/
//        return $this->fetch('article_list', [
//            'data' => $data
//        ]);

    }

    public function insert(){

        if($this->request->isPost()){
            $title = $this->request->post('title');
            if(!$title){
                $this->error('标题不能为空');
            }
            $content = $this->request->post('content');
            if(!$content){
                $this->error('内容不能为空');
            }

            $image = '';
            $file = $this->request->file('image');
            //入口文件的绝对路径
            $root = dirname($this->request->server('SCRIPT_FILENAME')) . '/';
            //文件需要保存的文件夹
            $uploadDir = './uploads/';
            //文件保存的绝对路径
            $uploadPath = $root . $uploadDir;
            //移动并保存文件
            $info = $file->move($uploadPath);
            if($info){
                $image = $uploadDir . $info->getSaveName();
            }

            $data = [
                'title' => $title,
                'image' => $image,
                'cid' => $this->request->post('cid'),
                'content' => $content,
                'hits' => $this->request->post('hits', 1),
                'keywords' => $this->request->post('keywords'),
                'update_time' => date('Y-m-d H:i:s'),
                'create_time' => date('Y-m-d H:i:s'),
            ];
            $save = $this->articles->insert($data);
            if($save){
                $this->success('添加成功', 'article/index');
            }else{
                $this->error('添加失败');
            }
        }
        return $this->fetch('article_add');

    }

    public function edit(){

        $id = $this->request->get('id');
        if(!$id){
            $this->error('非法参数');
        }
        $article = $this->articles->find($id);
        $this->assign('article', $article);

        if($this->request->isPost()){
            $data = [
                'id' => $id,
                'title' => $this->request->post('title'),
                'image' => $this->request->post('image'),
                'cid' => $this->request->post('cid'),
                'content' => ($this->request->post('content')),
                'hits' => $this->request->post('hits', 0),
                'keywords' => $this->request->post('keywords'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            if($this->articles->update($data, $id)){
                $this->success('修改成功', 'article/index');
            }else{
                $this->error('修改失败');
            }


        }


        return $this->fetch('article_edit');

    }

    public function delete(){

        $id = $this->request->param('id');
        if(!$id){
            $this->error('非法参数');
        }
        if($this->articles->where('id', $id)->delete()){

            $this->success('删除成功', 'article/index');

        }else{
            $this->error('删除失败');
        }
            $this->error('未知错误');
    }

}