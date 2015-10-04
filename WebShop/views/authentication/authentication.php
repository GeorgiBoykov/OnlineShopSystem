<div class="authentication">
    <div class="form-box">
        <form class="form-horizontal" id="login-form" method="post">
            <fieldset>
                <legend>Login</legend>
                <div class="form-group">
                    <label for="inputUsername" class="col-lg-2 control-label">Username</label>
                    <div class="col-lg-10">
<!--                        <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Username">-->
                        <?php
                        MVCFramework\ViewHelpers\TextField::create()
                            ->addAttribute('name', 'username')
                            ->addAttribute('class', 'form-control')
                            ->addAttribute('id', 'inputUsername')
                            ->addAttribute('placeholder', 'Username')
                            ->render();
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                    <div class="col-lg-10">
<!--                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">-->
                        <?php
                            MVCFramework\ViewHelpers\PasswordField::create()
                                ->addAttribute('name', 'password')
                                ->addAttribute('class', 'form-control')
                                ->addAttribute('id', 'inputPassword')
                                ->addAttribute('placeholder', 'Password')
                                ->render();
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <input type="submit" class="btn btn-primary" value="Login"/>
                    </div>
                </div>
                <?php $token = MVCFramework\ViewHelpers\CsrfToken::create(); $token->render() ?>
            </fieldset>
        </form>
    </div>
    <div class="form-box">
        <form class="form-horizontal" method="post" id="register-form">
            <fieldset>
                <legend>Register</legend>
                <div class="form-group">
                    <label for="inputUsername" class="col-lg-2 control-label">Username</label>
                    <div class="col-lg-10">
<!--                        <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Username">-->
                        <?php
                            MVCFramework\ViewHelpers\TextField::create()
                            ->addAttribute('name', 'username')
                            ->addAttribute('class', 'form-control')
                            ->addAttribute('id', 'inputUsername')
                            ->addAttribute('placeholder', 'Username')
                            ->render();
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                    <div class="col-lg-10">
<!--                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">-->
                        <?php
                        MVCFramework\ViewHelpers\PasswordField::create()
                            ->addAttribute('name', 'password')
                            ->addAttribute('class', 'form-control')
                            ->addAttribute('id', 'inputPassword')
                            ->addAttribute('placeholder', 'Password')
                            ->render();
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                    <div class="col-lg-10">
<!--                        <input type="text" name="email" class="form-control" id="inputEmail" placeholder="Email">-->
                        <?php
                            MVCFramework\ViewHelpers\TextField::create()
                            ->addAttribute('name', 'email')
                            ->addAttribute('class', 'form-control')
                            ->addAttribute('id', 'inputEmail')
                            ->addAttribute('placeholder', 'Email')
                            ->render();
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <input type="submit" class="btn btn-primary" value="Register"/>
                    </div>
                </div>
                <?php $token->render(); ?>
            </fieldset>
        </form>
    </div>
</div>