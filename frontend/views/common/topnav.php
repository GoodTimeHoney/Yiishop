<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w1210 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，欢迎<?=!Yii::$app->user->isGuest?Yii::$app->user->identity->username:""?>来到京西！[
                    <?php
                $htmlOne=<<<html
<a href="/user/login">登录</a>] [<a href="/user/reg">免费注册</a>
html;
                $htmlTwo=<<<html
<a href="/user/logout">注销</a>
html;

              //判断为登录
                    if(Yii::$app->user->isGuest){
                        echo $htmlOne;
                    }else{
                        echo $htmlTwo;
                    }




                    ?>
                    ] </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->
