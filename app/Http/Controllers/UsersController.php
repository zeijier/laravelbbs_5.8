<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequset;
use App\User;
//因为我们使用了命名空间，所以需要在顶部加载 use App\Handlers\ImageUploadHandler;；
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>'show']);
    }
//    Laravel 会自动解析定义在控制器方法（变量名匹配路由片段）中的 Eloquent 模型类型声明。
//    在上面代码中，由于 show() 方法传参时声明了类型 —— Eloquent 模型 User，对应的变量名 $user 会匹配路由片段中的 {user}，
//    这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例。
    public function show(User $user){
        return view('users.show',compact('user'));
    }
    public function edit(User $user){
//  这里 update 是指授权类里的 update 授权方法，$user 对应传参 update 授权方法的第二个参数。
//正如上面定义 update 授权方法时候提起的，调用时，默认情况下，我们 不需要 传递第一个参数，也就是当前登录用户至该方法内，
//因为框架会 自动 加载当前登录用户。
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    public function update(User $user,UserRequset $request,ImageUploadHandler $uploader){
        $this->authorize('update',$user);
// 表单请求验证（FormRequest）的工作机制，是利用 Laravel 提供的依赖注入功能，在控制器方法，如上面我们的 update() 方法声明中，
//传参 UserRequest。这将触发表单请求类的自动验证机制，验证发生在 UserRequest 中，
//并使用此文件中方法 rules() 定制的规则，只有当验证通过时，才会执行 控制器 update() 方法中的代码。
//否则抛出异常，并重定向至上一个页面，附带验证失败的信息。
        $data = $request->all();
        if ($request->avatar){
            $result = $uploader->save($request->avatar,'avatars',$user->id,416);
            if ($result){
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);

        return redirect()->route('users.show',$user->id)->with('success', '个人资料更新成功！');
    }
}
