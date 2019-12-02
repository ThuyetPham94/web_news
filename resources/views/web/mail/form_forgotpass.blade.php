<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>VAPP</title>
        <style>

        input[type="radio"] {
            position: fixed;
            left: -100px;
        }

        input:not([type="radio"]) {
            appearance: none;
            background-color: #fff;
            display: block;
            transition: 300ms ease;
            border-radius: 7px;
            border: 0;
            max-height: 0;
            margin: 0;
            padding: 0 10px;
            overflow: hidden;
            width: 250px;
            opacity: 0;
            font-size: 16px;
            text-align: center;
            outline: 0;
        }

        [id="sign-up"]:checked ~ input.sign-up {
            max-height: 40px;
            padding: 10px;
            margin: 10px 0;
            opacity: 1;
        }

        button {
            width: 250px;
            height: 40px;
            border-radius: 7px;
            background-color: #16a085;
        }

        label {
            position: relative;
            display: inline-block;
            text-align: center;
            font-weight: 700;
            cursor: pointer;
            color: #16a085;
            transition: 300ms ease;
            width: calc(100% / 3 - 4px);
        }

        [id="sign-up"]:checked ~ [for="sign-up"] {
            color: #fff;
        }


        .flex-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            height: 300px;
            text-align: center;
        }

        body {
            background-color: #1abc9c;
            font-size: 16px;
        }
        </style>
    </head>
    <body>
        <div class="flex-wrap">
    <fieldset>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color:red">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="http://wordsgrow.com.vn/forgot?encrytCode={{ Request()->encrytCode }}" method="POST">
            @csrf
            <input type="radio" name="rg" id="sign-up" checked/>
            <label for="sign-up">Thay đổi mật khẩu</label>
            <input class="sign-up sign-in" type="password" placeholder ="Mật khẩu" name="password" />
            <input class="sign-up" type="password" placeholder ="Xác nhận mật khẩu" name="password_confirm"/>
            <button type="submit">Thay đổi</button>
        </form>
    </fieldset>
</div>
    </body>
</html>
