<?php echo form_open("login");?>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div> 
        <div class="social-auth-links text-center mb-3">
          <button type="submit" class="btn btn-block btn-primary">
           Login
          </button>
        </div>
<?php echo form_close();?>