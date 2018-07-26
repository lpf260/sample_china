<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Mail;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show','create','store','index','confirmEmail']
        ]);

        $this->middleware('guest',[
            'only'  => ['create']
        ]);
    }

    /**
     * 查看所有用户
     * @return [type] [description]
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    //
    public function create()
    {
        return view('users.create');
    }

    /**
     *
     */
    public function show(User $user)
    {
        //取出用户微博
        $statuses = $user->statuses()
                        ->orderBy('created_at','desc')
                        ->paginate(30);

        return view('users.show', compact('user','statuses'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'      => 'required|max:50',
            'email'     => 'required|email|unique:users|max:255',
            'password'  => 'required|confirmed|min:6'
        ]);


        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        //注册之后自动登录
        //Auth::login($user);
        $this->SendEmailConfirmationTo($user);

        session()->flash('success','验证邮件已发送到你的注册邮箱上，请注意查收。');
        //return redirect()->route('profile', ['id'=>1]);
        return redirect('/');
    }

    public function edit(User $user)
    {
        /*        if(Auth::user()->can('update',$user))
                {
                    return view('users.edit',compact('user'));
                }else{
                    return "mistake";
                };
                if(Auth::user()->can('update',$user))
                {
                    return view('users.edit',compact('user'));
                }else{
                    return "mistake";
                };
        */
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    //修改用户资料
    public function update(User $user, Request $request)
    {
        $this->validate($request,[
            'name'      => 'required|max:50',
            'password'  => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success','个人资料更新成功！');
        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user)
    {
        /**
         * 这里 update 是指授权类里的 update 授权方法，$user 对应传参 update 授权方法的第二个参数。正如上面定义 update 授权方法时候提起的，调用时，默认情况下，我们 不需要 传递第一个参数，也就是当前登录用户至该方法内，因为框架会自动加载当前登录用户。
         */
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back();
    }

    public function SendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');

        $to = $user->email;
        $subject = "感谢您注册 Sample 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {
        //token用一次就会置空，在这里就是通过token查询
        $user = User::where('activation_token',$token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);


        session()->flash('success', '恭喜你，激活成功！');

        return redirect()->route('users.show', [$user]);
    }
}
