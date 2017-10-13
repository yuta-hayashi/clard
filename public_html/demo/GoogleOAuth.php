<?php

class GoogleOAuth {

  private $config;

  function __construct(){
    $this->config = include dirname(__FILE__).'/config.php';
    session_start();
  }

  private function join_params($array){
    return implode(
      '&',
      array_map(
        function($k,$v){
          return $k."=".urlencode($v);
        },
        array_keys($array),
        $array
      )
    );
  }

  private function do_request($url, $params, $type){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if($type=='POST'){
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt ($ch, CURLOPT_POSTFIELDS, $this->join_params($params));
      curl_setopt ($ch, CURLOPT_POST, 1);
    }else{
       curl_setopt($ch, CURLOPT_URL, $url.'?'.$this->join_params($params));
    }
    $response =  curl_exec($ch);
    curl_close($ch);
    return $response;
  }

  function is_logged_in(){
    return isset($_SESSION['email']);
  }

  function get_email(){
    return isset($_SESSION['email']) ? $_SESSION['email'] : null;
  }

  function has_refresh_token(){
    return isset($_COOKIE['refresh_token']);
  }

  function create_oauth_url(){
    $state = sha1(openssl_random_pseudo_bytes(1024));
    $_SESSION['state'] = $state;
    $params = array(
        'scope' => 'openid email',
        'state' => $state,
        'redirect_uri' => $this->config['redirect_uri'],
        'response_type' => 'code',
        'client_id' => $this->config['client_id'],
        'approval_prompt' => 'force',
        'access_type' => 'offline'
      );
    $url = "https://accounts.google.com/o/oauth2/auth?";
    $url .= $this->join_params($params);
    return $url;
  }

  function auth(){
    if(!isset($_SESSION['state']) || !isset($_GET['state'])) return 1;
    if($_SESSION['state'] != $_GET['state']) return 2;

    $url = "https://www.googleapis.com/oauth2/v3/token";
    $params = array(
          'code' => $_GET['code'],
          'client_id' => $this->config['client_id'],
          'client_secret' => $this->config['client_secret'],
          'redirect_uri' => $this->config['redirect_uri'],
          'grant_type' => 'authorization_code'
        );
    $response = $this->do_request($url, $params, 'POST');
    $response = json_decode($response);

    if(!isset($response->id_token) || !isset($response->refresh_token)) return 3;

    $refresh_token = $response->refresh_token;
    setcookie('refresh_token', $refresh_token, time()+3600*24*365);

    $url = "https://www.googleapis.com/oauth2/v1/tokeninfo";
    $params = array('id_token' => $response->id_token);

    $response = $this->do_request($url, $params, 'GET');
    $response = json_decode($response);

    if (!isset($response->email)) return 4;

    $email = $response->email;

    #if(!preg_match("/@gm.ishikawa-nct.ac.jp$/", $email)) return 5;

    $_SESSION['email'] = $email;
    setcookie('refresh_token', $refresh_token, time()+3600*24*365);

    return 0;
  }

  function re_oauth(){
    if (!isset($_COOKIE['refresh_token'])) return 1;

    $refresh_token = $_COOKIE['refresh_token'];
    $url = "https://accounts.google.com/o/oauth2/token";
    $params = array(
      'client_id' => $this->config['client_id'],
      'client_secret' => $this->config['client_secret'],
      'refresh_token' => $refresh_token,
      'grant_type' => 'refresh_token'
    );
    $response = $this->do_request($url, $params, 'POST');
    $response = json_decode($response);

    if(!isset($response->id_token)){
      setcookie('refresh_token','', time() - 3600);
      return 2;
    }

    $url = "https://www.googleapis.com/oauth2/v1/tokeninfo";
    $params = array('id_token' => $response->id_token);
    $response = $this->do_request($url, $params, 'GET');
    $response = json_decode($response);

    if (!isset($response->email)) {
      setcookie('refresh_token','', time() - 3600);
      return 3;
    }

    $email = $response->email;
    $_SESSION['email'] = $email;

    return 0;
  }

  function logout(){
    if(isset($_SESSION['refresh_token'])){
      $token = $_SESSION['refresh_token'];
      $url = "https://accounts.google.com/o/oauth2/revoke";
      $params = array(
        'token' => $token
      );
      $this->do_request($url, $params, 'GET');
    }

    $_SESSION = array();
    setcookie('refresh_token','', time() - 3600);
    session_destroy();
  }

}



?>
