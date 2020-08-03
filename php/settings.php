<?php session_start(); ?>
<script type="text/javascript" src="./js/verification.js" defer></script>

<div id="datacells">
    <div id="settings-div">
        <div id="profile-banner" style="background-image: url(../assets/banners/default.png);">
            <img id="settings-pfp" src=<?=$_SESSION['pfp'];?> onerror=this.src="../assets/pfps/default.png" width=130px height=130px>
        </div>

        <div>
            <p>Your Profile</p>
            <hr>
            <form class="form-settings" method="POST">
        
                <div>
                    <label class="labels" for="email-settings">Email:</label>
                    <input type="text" name="email" id="email" oninput="emailVal()" placeholder="Email">
                    <input type="button" id="change-email" onclick="emailUpdate()" value="Change" />
                    <br>
                    
                </div>
        
                <div>
                    <label class="labels" for="password-settings">Password:</label>
                    <input type="password" name="password" id="psw" oninput="pswVal()" placeholder="Password">
                    <input type="button" id="change-password" onclick="passwordUpdate()" value="Change" />
                    <br>
                </div>
            </form>

            <form class="form-settings" method="POST" action="upload.php" enctype="multipart/form-data">
                <div>
                    <label class="labels" for="pfp">Change Profile Picture</label>
                    <input type="file" name="pfp" value="Change" />
                    <br>
                </div>

                <div>
                    <label class="labels" for="banner">Change Profile Banner</label>
                    <input type="file" name="banner" value="Change" />
                    <br>
                </div>
                    <input type="submit" name="uploadBtn" value="Upload" />

            </form>
            <div id="results">
                    <p id="et" class="tooltip"></p>
                    <p id="pt" class="tooltip"></p>
            </div>
        </div>
    </div>
</div>
<script>
function emailUpdate() {
    var email =  $("#email").val()

    $.post("submit.php", { email: email },

    function(data) {
	 $('#results').html(data);
	 $('#form-settings')[0].reset();
    });
}
function passwordUpdate() {
    var password =  $("#psw").val()

    $.post("submit.php", { password: password },

    function(data) {
	 $('#results').html(data);
	 $('#form-settings')[0].reset();
    });
}
</script>