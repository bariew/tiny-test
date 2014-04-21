<?php $data = Tiny::app()->controller->data;?>
<form method="post" action="/login" id="user" class="text-center form-vertical">   
<fieldset class="yellow view">
        <label class="required" for="LoginForm_email">Email <span class="required">*</span></label>
        <input type="text" id="LoginForm_email" name="LoginForm[email]" value="<?php echo @$data['LoginForm']['email'];?>">        
        <label for="LoginForm_password">Password</label>
        <input type="password" id="LoginForm_password" name="LoginForm[password]" style="" value="<?php echo @$data['LoginForm']['password'];?>"> 
        <div class="form-actions">
            <button name="yt0" type="submit" class="btn btn-primary">Log in</button>            <br><br>
            <a href="/register" class="colorbox text-success cboxElement">Register</a>            
        </div>
    </fieldset>
</form>