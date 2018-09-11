<?php
namespace app\admin\server;

use app\common\model\Admin;
use app\common\model\AdminRole;
use app\common\model\Article;
use think\facade\Cookie;
use SC;

//登录业务
class AdminServer
{
    /**
     * 后台登录
     * @param $username 用户名
     * @param $password 密码
     * @return array 登录提示
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($username,$password,$rember='')
    {
        $admin = Admin::with('adminRole')->where('user_name','=',$username)->find();
        if (!$admin){
            return ajax_return(0,'账号错误');
        }
        if (!$admin->password == md5(hash('sha512',$password))){
            return ajax_return(0,'密码错误');
        }
        if ($admin->adminRole->act_list == '0' || empty($admin->adminRole->act_list)){
            return ajax_return(0,'该账号没有权限');
        }
        SC::setLoginIdSession($admin->admin_id);
        SC::setUserInfoSession($admin->user_name);
        SC::setUserRoleSession($admin->adminRole->role_name);
        $ip = get_real_ip();
        Admin::where('user_name',$username)->update(['last_login' => time(),'last_ip' => $ip]);
        if ($rember == 'on' && !Cookie::has('rember')){
            Cookie::set('username',$username,3600*24*30);
            Cookie::set('password',$password,3600*24*30);
            Cookie::set('rember','on',3600*24*30);
        }elseif($rember == ''){
            Cookie::clear('shop_');
        }
        return ajax_return(1,'登录成功');
    }

    //登出
    public function logout()
    {
        SC::delLoginSession();
    }

    public function test($info)
    {
        $res = Article::create($info);
        if ($res){
            return ajax_return(1,'添加成功');
        }else{
            return ajax_return(0,'添加失败');
        }
    }

    public function getList($id)
    {
        $res = Article::where('admin_id',$id)->select();
        if ($res){
            return $res->toArray();
        }else{
            return false;
        }
    }

    public function getarticle($id)
    {
        $info = Article::get($id);
        if ($info){
            return $info->toArray();
        }else{
            return false;
        }
    }

    public function updateArticle($id,$article)
    {
        $res = Article::where('id',$id)->update($article);
        if ($res){
            return ajax_return(1,'修改成功');
        }else{
            return ajax_return(0,'修改失败');
        }
    }

    /**
     * 上传头像
     * @param $admin_id 用户id
     * @param $base64_image_content  图像资源
     * @return array
     */
    public function updateLogo($admin_id,$base64_image_content)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            $new_file = "./static/upload/logo/";
            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0777,true);
            }
            $img=hash('sha1',time().rand(11111,99999)) . "." .$type;
            $new_file = $new_file . $img;
            //将图片保存到指定的位置
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                Admin::where('admin_id',$admin_id)->update(array('logo'=>$new_file));
                return ajax_return(0,$new_file);
            }else{
                return ajax_return(1,'上传失败');
            }
        }else{
            return ajax_return(1,'请选择图片');
        }
    }
}