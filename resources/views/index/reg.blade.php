<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <title>注册</title>
</head>
<body>
        <div class="page-header">
             <h2 style="text-align:center">注册
                    <small></small>
            </h2>
        </div>
    <form class="form-horizontal" role="form" action="{{url('doreg')}}" method="post" enctype="multipart/form-data">
        <div class="form-group has-error">
            <label class="col-sm-2 control-label" for="inputError">
                公司名
            </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="l_company" id="inputError">
            </div>
        </div>
        <div class="form-group has-error">
            <label class="col-sm-2 control-label" for="inputError">
                法人
            </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="l_legal" id="inputError">
            </div>
        </div>
        <div class="form-group has-error">
            <label class="col-sm-2 control-label" for="inputError">
                公司地址
            </label>
            <div class="col-sm-8">
                <input type="text" class="form-control"  name="l_address" id="inputError">
            </div>
        </div>
        <div class="form-group has-error">
            <label class="col-sm-2 control-label" for="inputError">
                营业执照照片
            </label>
            <div class="col-sm-8">
                <input type="file" class="form-control" name="l_logo" id="inputError">
            </div>
        </div>
        <div class="form-group has-error">
            <label class="col-sm-2 control-label" for="inputError">
                联系电话
            </label>
            <div class="col-sm-8">
                <input type="text" class="form-control"  name="l_phone" id="inputError">
            </div>
        </div>
        <div class="form-group has-error">
            <label class="col-sm-2 control-label" for="inputError">
                邮箱
            </label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="l_email" id="inputError">
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
                <button type="submit" class="btn btn-primary">注册</button>
            </div>
        </div>
       
    </form>
</body>
</html>




