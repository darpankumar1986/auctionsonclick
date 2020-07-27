<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class fb{

        public function __construct()
        {
                $this->CI = get_instance();
                $this->CI->config->load("facebook",TRUE);
                $config = $this->CI->config->item('facebook');
                $this->CI->load->library('facebook', $config);
        }
		
		public function facebook_javascript()
		{
			?>
			<script>
			window.fbAsyncInit = function() {
							FB.init({
							  appId: '<?php echo $this->CI->facebook->getAppID() ?>',
							  cookie: true,
							  xfbml: true,
							  oauth: true
							});
							FB.Event.subscribe('auth.login', function(response) {
							  window.location.reload();
							});
							FB.Event.subscribe('auth.logout', function(response) {
							  window.location.reload();
							});
							};

					  (function() {
							var e = document.createElement('script'); e.async = true;
							e.src = document.location.protocol +
							  '//connect.facebook.net/en_US/all.js';
							document.getElementById('fb-root').appendChild(e);
					  }());
			</script>
			<?php
		}
		
        public function initialize()
        {
			$user_profile = array();

			$user = $this->CI->facebook->getUser();
			if($user)
			{
					$user_profile = $this->CI->facebook->api('/me');
			}
			return $user_profile;
        }

        public function createLoginLink()
        {
                $login_params = array(
                'scope' => 'email'
                );
                return $url = $this->CI->facebook->getLoginUrl($login_params);
        }

        public function facebookLogout($data="")
        {
                $this->CI->facebook->destroySession();
        }


}
?>
