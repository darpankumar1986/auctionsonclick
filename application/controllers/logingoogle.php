 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginGoogle extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    public function index()
    {
        require_once 'openid.php';
        $openid = new LightOpenID("localhost");
        $openid->identity = 'https://www.google.com/accounts/o8/id';
        $openid->required = array(
            'namePerson/first',
            'namePerson/last',
            'contact/email',
            'birthDate', 
            'person/gender',
            'contact/postalCode/home',
            'contact/country/home',
            'pref/language',
            'pref/timezone',  
        );
//  $openid->returnUrl = 'http://localhost/login_thirdparty/login_google.php';

    $openid->returnUrl = 'http://localhost/login_thirdparty/codeigniterlogin/index.php/logingoogle/loginAuth';

//  echo '<a href="'.$openid->authUrl().'">Login with Google</a>';

        $data['openid'] = $openid;
        $this->load->view('googleLoginView', $data);
    }

    public function loginAuth()
    {
        $this->login_model->index();
    }
}