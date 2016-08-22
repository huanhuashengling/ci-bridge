<?php
interface IGeneric
{
    function _init();
    function _config();
    function _render($obj);
}

class Generic extends CI_Controller
{
    protected $format = 'html';
    protected $extension = '';

    public function __construct()
    {
        defined('BASEPATH') or exit('No direct script access allowed');

        parent::__construct();

        if ($_SERVER["SERVER_PORT"] != 443 && $_SERVER['SERVER_ADDR'] != '127.0.0.1') {
            // only apply https to server requests
            // redirect("https://".$_SERVER['HTTP_HOST']);
        }
        $this->_startSession();
        $this->load->library('UtilLibrary');
        
    }

    protected function _render($obj)
    {
        // if not logged in yet, get english even though we don't use them...
        $params = $this->_getParams();

        //************ now call page
        if (!isset($obj['header'])) {
            $obj['header']  = $this->load->view('header', $params, true);
        }
        if (!isset($obj['footer'])) {
            $obj['footer']  = $this->load->view('footer', $params, true);
        }
        if (!isset($obj['body'])) {
            $obj['body']    = "Hello World";
        }
        if (!isset($obj['bodycss'])) {
            $obj['bodycss'] = "mainbody";
        }
        if (!isset($obj['wrapper'])) {
            $obj['wrapper'] = "wrapper";
        }

        switch ($this->format) {
            case 'json':
                echo json_encode($obj);
                die();
            case 'body':
                // $obj['header'] = '';
                // $obj['footer'] = '';
                echo $obj['body'];
                break;
            default:
                $this->load->view($obj['wrapper'], $obj);
                break;
        }
        return true;
    }

    protected function _getParams()
    {
        $params = [];
        $messages = [];

        $params = array_merge($params, $messages, [
            'route' => [
                'class' => $this->router->class,
                'method' => $this->router->method,
            ],
        ]);

        return $params;
    }

    public function _remap($method, $params = array())
    {
        if (count($params)) {
            // if we have parameters, the format will be the last array
            $paramParts = explode('.', $params[count($params) - 1]);
            if(count($paramParts) > 1) {
                $this->format = array_pop($paramParts);
                $params[count($params) - 1] = implode('.', $paramParts);
                $this->extension = $this->format;
            }
        } else {
            // if we have parameters, the format will be the last array
            $methodParts = explode('.', $method);
            if (count($methodParts) > 1) {
                list($method, $this->format) = $methodParts;
                $this->extension = $this->format;
            }
        }

        $baseSeg = explode('/', $this->config->item('base_url'));  // { [0]=> string(5) "http:" [1]=> string(0) "" [2]=> string(21) "nnn.carespan.clinic" [3]=> string(6) "clinic"}
        if ($_SERVER['HTTP_HOST'] != $baseSeg[2]) {
            echo $_SERVER['HTTP_HOST'] . ' != ' . $this->config->item('base_url') . PHP_EOL;
            echo 'Need to update $config[\'base_url\'] in config.php' . PHP_EOL;
            die();
        }
        
        $method = $this->utillibrary->camelize($method, '-');
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }

    protected function _startSession()
    {
        // start PHP session
        @session_start();
    }

}
