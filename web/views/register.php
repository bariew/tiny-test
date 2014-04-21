<?php $data = Tiny::app()->controller->data;?>
<form method="post" action="/register" id="user" class="text-center form-vertical">   
    <fieldset class="yellow view">
        <label class="required" for="LoginForm_email">Email <span class="required">*</span></label>
        <input type="text" id="LoginForm_email" name="LoginForm[email]" value="<?php echo @$data['LoginForm']['email'];?>">        
        <label for="LoginForm_password">Password</label>
        <input type="password" id="LoginForm_password" name="LoginForm[password]" style="" value="<?php echo @$data['LoginForm']['password'];?>"> 
        <label for=LoginForm_image>Please enter code below:</label>
        <img src="data:image/png;base64,<?php echo $data['LoginForm']['image'];?>">
        <br />
        <input type="text" id="LoginForm_image" name="LoginForm[challenge_response_answer]">        
        <input type="hidden" name="LoginForm[challenge_response_token]" value="<?php echo $data['LoginForm']['token'];?>" />
            
        <div class="form-actions">
            <button name="yt0" type="submit" class="btn btn-primary">Send</button>            
            <br><br>
        </div>
    </fieldset>
</form>