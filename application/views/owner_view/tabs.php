<?php
//Active URL Array
    $myActiveURL = array(
                    array("owner/dashboard"),
                    array("owner/myMessage", "owner/myMessageUser", "owner/myMessageTrash", "myMessage_new", "myMessage_reply_msg"),
                    array("owner/myProfile", "owner/myProfileEdit", "owner/myProfileChangePassword")
                );
?>


<a href="/owner/dashboard">
    <li class="<?php echo ((in_array(uri_string(), $myActiveURL[0], true)) ? 'active' : ''); ?>" rel="tab5">My Summary</li>
</a>
<a href="/owner/myMessage">
    <li class="<?php echo ((in_array(uri_string(), $myActiveURL[1], true)) ? 'active' : ''); ?>" rel="tab7">My Activity</li>
</a>
<a href="/owner/myMessage">
    <li class="<?php echo ((in_array(uri_string(), $myActiveURL[1], true)) ? 'active' : ''); ?>" rel="tab7">My Message</li>
</a>

<a href="/owner/myProfile">
    <li class="<?php echo ((in_array(uri_string(), $myActiveURL[2], true)) ? 'active' : ''); ?>" rel="tab8">My Profile</li>
</a>
