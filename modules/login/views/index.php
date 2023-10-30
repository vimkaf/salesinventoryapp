<?php echo form_open('/login/log_me_in');?>
        <div class="input-group mb-3">

        <?php 
            echo form_label('Username');
            $attr['placeholder'] = 'Enter your username';
            $attr['autocomplite'] = 'off';
            echo form_input('username',$username, $attr);
          ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
        <?php 
            echo form_label('Password');
            $attr['placeholder'] = 'Enter your password';
            $attr['autocomplite'] = 'off';
            echo form_password('username',$username, $attr);
          ?>
          <!-- <input type="password" class="form-control" placeholder="password" name="password"> -->
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <!-- <input type="checkbox" id="remember"> -->
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <?php echo form_submit('submit','Login');?>
            <!-- <button type="submit" class="btn btn-primary btn-block">Sign In</button> -->
          </div>
          <!-- /.col -->
        </div>
<?php echo form_close();?>
