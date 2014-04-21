<?php $data = Tiny::app()->controller->data;?>
<form method="post" action="/account" id="user" class="text-center form-vertical">   
<fieldset class="yellow view">
        <label class="required" for="LoginForm_email">Email <span class="required">*</span></label>
        <input type="text" id="LoginForm_email" name="LoginForm[email]" value="<?php echo @$data['LoginForm']['email'];?>">        

        <label class="required" for="LoginForm_name">Name <span class="required">*</span></label>
        <input type="text" id="LoginForm_name" name="LoginForm[name]" value="<?php echo @$data['LoginForm']['name'];?>">        
        <label class="required" for="LoginForm_phone">Phone <span class="required">*</span></label>
        <input type="text" id="LoginForm_phone" name="LoginForm[phone]" value="<?php echo @$data['LoginForm']['phone'];?>">        

        <label for="LoginForm_password">Password</label>
        <input type="password" id="LoginForm_password" name="LoginForm[password]" style="" value="<?php echo @$data['LoginForm']['password'];?>">       
        <input type="hidden" name="LoginForm[api_token]" value="<?php echo $data['LoginForm']['token'];?>" />
        <div class="form-actions">
            <button name="yt0" type="submit" class="btn btn-primary">Send</button>            
            <br><br>
        </div>
    </fieldset>
</form>