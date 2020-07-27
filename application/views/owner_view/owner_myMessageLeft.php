<ul>
    <!--<li> <a href="/owner/myMessage"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon1.png"></span> Inbox</a></li>-->
    <li>
        <a href="/owner/myMessage" class="<?php echo uri_string() == 'owner/myMessage' ? 'active' : ''; ?>">
            <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon2.png"></span> Inbox
        </a>
    </li>
    
    <!--<li>
        <a href="/owner/myMessageUser" class="<?php echo uri_string() == 'owner/myMessageUser' ? 'active' : ''; ?>">
            <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon3.png"></span> User
        </a>
    </li>-->
    
    <!--<li> <a href="#"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon4.png"></span> Send</a></li>-->
    <li>
        <a href="/owner/myMessageTrash" class="<?php echo uri_string() == 'owner/myMessageTrash' ? 'active' : ''; ?>">
            <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon5.png"></span> Trash
        </a>
    </li>
</ul>