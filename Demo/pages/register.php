<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        /* Paste your CSS code here */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #edf1f4;
        }
        .register{
            position: relative;
            width: 380px;
            padding: 80px 50px 50px;
            box-shadow: 15px 15px 20px rgba(0,0 , 0, 0.1), -15px -15px 20px #fffb;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
        }
        .register form{
            position: relative;
            width: 100%;
        }
        .register form h2{
            font-size: 2em;
            margin-bottom: 30px;
            line-height: 0.9em;
        }
        .register form h2 span{
            font-weight: 300;
            font-size: 0.56em;
        }
        .register form .inputBox input{
            border: none;
            outline: none;
            background: transparent;
            border-radius: 10px;
            font-size: 1em;
        }
        .register form .inputBox input[type="text"],
        .register form .inputBox input[type="password"]{
            width: 100%;
            padding: 15px 20px;
            padding-left: 40px;
            margin-bottom: 20px;
            box-shadow: inset 5px 5px 10px rgba(0, 0, 0, 0.1), inset -5px -5px 10px #fff;
        }
        .register form .inputBox i{
            position: absolute;
            left: 20px;
            top: 25%;
        }
        .register form label{
            display: flex;
            align-items: center;
        }
        .register form input[type="checkbox"]{
            margin-right: 5px;
        }
        .register form .inputBox input[type="submit"]{
            margin-top: 20px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1), -5px -5px 10px #fff;
            width: 100%;
            padding: 15px 20px;
            cursor: pointer;
            font-weight: 600;
        }
        .register form .inputBox input[type="submit"]:focus{
            box-shadow: inset 5px 5px 10px rgba(0, 0, 0, 0.1), -5px -5px 10px #fff;
            border: 3px solid #edf1f4;
            padding: 15px 20px 10px;
            background: linear-gradient(315deg, #03a9f4, #0082bc);
        }
    </style>
    <title>Đăng Ký</title>
</head>
<body>
    <div class="register">
        <form action="">
            <h2>Xin chào!<br><span>Chào mừng bạn!</span></h2>
            <div class="inputBox">
                <input type="text" placeholder="Họ và tên"/>
                <i class="fa-regular fa-user"></i>
            </div>
            <div class="inputBox">
                <input type="text" placeholder="Email"/>
                <i class="fa-regular fa-envelope"></i>
            </div>
            <div class="inputBox">
                <input type="password" placeholder="Mật khẩu"/>
                <i class="fa-solid fa-lock"></i>
            </div>
            <label for="">
                <input type="checkbox">Nhớ tài khoản của tôi
            </label>
            <div class="inputBox">
                <input type="submit" value="Đăng ký">
            </div>
        </form>
    </div>
</body>
</html>
