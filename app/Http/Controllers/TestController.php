<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\VerifyCsrfToken;
use Intervention\Image\ImageManagerStatic as Image;

class TestController extends Controller
{
    //
    public function __construct()
    {
    }

    //测试header头
    public function test(Request $request)
    {

        $message =  response('Hello World', 200);
        $message = $message->withHeader('foo', 'bar');

        echo $message->getHeaderLine('foo');
    }

    //上传图片
    public function upload(Request $request)
    {
        $photo = $request->file('pic');
        if(!$photo){
            return response()->json([
                'code'      => '500',
                'message'   => 'File Error'
            ]);
        }else{
            $stream = Image::make($photo)->widen(100, function ($constraint) {
                $constraint->upsize();
            })->resizeCanvas(100,20)->stream();

            $code = $stream->getContents();
            file_put_contents('a.png',$code);
        }
    }

    //加密解密
    public function crypt()
    {
        $password = "123456";
        $cryptPassword = encrypt($password);
        echo $cryptPassword.PHP_EOL;
        $passwordUncrypt = decrypt($cryptPassword);
        echo $passwordUncrypt;
    }
}
