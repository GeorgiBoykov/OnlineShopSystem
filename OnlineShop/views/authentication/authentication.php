<div class="authentication">
    <div class="authentication-box">
        <form class="form-horizontal" method="post" action="authentication/login">
            <fieldset>
                <legend>Login</legend>
                <div class="form-group">
                    <label for="inputUsername" class="col-lg-2 control-label">Username</label>
                    <div class="col-lg-10">
                        <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Username">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                    <div class="col-lg-10">
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <input type="submit" class="btn btn-primary" value="Login"/>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="authentication-box">
        <form class="form-horizontal" method="post" action="authentication/register">
            <fieldset>
                <legend>Register</legend>
                <div class="form-group">
                    <label for="inputUsername" class="col-lg-2 control-label">Username</label>
                    <div class="col-lg-10">
                        <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Username">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                    <div class="col-lg-10">
                        <input type="text" name="email" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                    <div class="col-lg-10">
                        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <input type="submit" class="btn btn-primary" value="Register"/>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>