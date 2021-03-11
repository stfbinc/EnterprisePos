<?php
  
  
?>

<div class="container">

    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3"></div>
        <div class="col-lg-6 col-md-6">
            <form id="loginform">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="dropdown-label pull-left"><?php echo $translation->translateLabel("Username"); ?>:</label>
                        </div>
                        <div class="col-xs-6">
                            <input name="username" class="form-control pull-right b-none"/>
                        </div>
                    </div>
                </div>
                <div  id="user_wrong_message" style="color:red; padding-bottom:20px; display:none">
                    <strong>These credentials do not match our records.</strong>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="dropdown-label pull-left"><?php echo $translation->translateLabel("Password"); ?>:</label>
                        </div>
                        <div class="col-xs-6">
                            <input name="password" type="password" class="form-control pull-right b-none"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="dropdown-label pull-left"><?php echo $translation->translateLabel("Terminal ID"); ?>:</label>
                        </div>
                        <div class="col-xs-6">
                            <input name="terminalID" type="text" class="form-control pull-right b-none"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="dropdown-label pull-left"><?php echo $translation->translateLabel("Captcha"); ?>:</label>
                        </div>
                        <div class="col-xs-6">
                            <input name="captcha" id="captcha" class="form-control" type="text" required placeholder="<?php echo $translation->translateLabel("Enter captcha"); ?>">
                        </div>
                        <div class="col-xs-6">
                            <img id="imgcaptcha" src="<?php echo $oscope->captchaBuilder->inline(); ?>" />
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>
                    <div class="row">
                        <div class="col-md-1 col-lg-1">
                        </div>
                        <div class="col-md-4 col-lg-4" style="padding-bottom:20px">
                            <a href="#" style="color:blue">
                                <?php echo $translation->translateLabel("Forgot Username / Password"); ?>
                            </a>
                        </div>
                        <div class="col-md-4 col-lg-4" style="padding-bottom:20px">
                            <button type="button" class="btn btn-primary" id="loginButton">
                                <?php echo $translation->translateLabel("Login"); ?>
                            </button>
                        </div>

                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#loginButton').click(function(){
     var loginform = $('#loginform');

     var reload = false;
     var reload_url = '';
     serverProcedureAnyCall("users", "login", loginform.serialize(), function(data, error){
         if(data)
            {

                data = JSON.parse(data);
                console.log(data);
                console.log(data.OpenShift)
                if(data.OpenShift == 1){
                    reload_url = "index.php#/?page=forms&action=openshift";
                }
                else {

                    //location.reload();
                    reload_url = "index.php#/?page=forms&action=searchcustomers";
                }
                reload = true;    
    
                if(reload) {
                    window.location.href = reload_url; 
                }     
            }
             
         else {
             console.log(data, error);
             var res = error.responseJSON;
             
             if(res.wrong_user){
                 $("#captcha").addClass("has-error");
                 $("#username").addClass("has-error");
                 $("#password").addClass("has-error");
                 $("#user_wrong_message").css("display", "block");
             }else{
                 $("#username").removeClass("has-error");
                 $("#password").removeClass("has-error");
                 $("#user_wrong_message").css("display", "none");
                 $("#captcha").removeClass("has-error");
             }
             document.getElementById('imgcaptcha').src = res.captcha; 
         }
     });

      
     
 }); 
</script>