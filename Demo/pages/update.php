<?php
        $nameError = "";
        $name = "";
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            if(isset($_POST["Enter"])){
                if(empty($_POST["name"])){
                    $nameError = "*khong duoc de trong";
                }else {
                    $name = $_POST["name"];
                    if(!preg_match("/^[a-zA-Z]*$/", $name)){
                        $nameError = "khong chua ky tu dat biet";
                    }else{
                        echo $name;
                    }
                }
            }
        }
    ?>
    <?php
        $emailError = "";
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            if(isset($_POST["Enter"])){
                if(empty($_POST["gmail"])){
                    $emailError = "*khong duoc de trong";
                }
            }
        }
    ?>
    <style>
        .error{color:red;}
    </style>

    <form action="pages/action.php?req=login" method="post">
        Username:<input type="text" name="username" placeholder="nhap vao ten"/>
        <span class="error"><?php echo $nameError?></span><br><br>
        Password:<input type="text" name="password" placeholder="abc@gmail.com"/>
        <span class="error"><?php echo $emailError?></span>
        <br><br>
        <input type="submit" value="Login" name="Login">
    </form>