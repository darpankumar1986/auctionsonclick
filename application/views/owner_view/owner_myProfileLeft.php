<?php //echo uri_string(); ?>

<ul>
    <li>
        <a href="/owner/myProfile" class="<?php echo uri_string() == 'owner/myProfile' ? 'active' : ''; ?>">
            <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon1.png"></span> View Profile
        </a>
    </li>
    <li>
        <a href="/owner/myProfileChangePassword">
            <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/ico-create_event-loged.png"></span> Change Password
        </a>
    </li>
</ul>
