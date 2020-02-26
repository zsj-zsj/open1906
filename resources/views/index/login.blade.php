<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <title>登录</title>
</head>
<body>
        <div class="page-header">
                <h2 style="text-align:center">登录
                       <small></small>
               </h2>
           </div>
        {{session('a')}}   
    <form class="form-horizontal" role="form" action="{{url('dologin')}}" method="post">
            <div class="form-group has-error">
                <label class="col-sm-2 control-label" for="inputError" >
                   用户名
                </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="l_phone"  placeholder="请输入邮箱或手机号" id="inputError">
                </div>
            </div>
            <div class="form-group has-error">
                <label class="col-sm-2 control-label" for="inputError">
                    密码
                </label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="l_pass" id="inputError">
                </div>
            </div>
            <div class="form-group has-error">
                    <label class="col-sm-2 control-label" for="inputError">
        
                    </label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">登录</button>
                    </div>
                </div>
    </form>
</body>
</html>