<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct($config = "rest")
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding,Authorization");
        parent::__construct();
    }

    public function login()
    {
        if ($this->input->method() === 'post') {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($email == "test@mail.com" and $password == "test") {
                $token_data['userEmail'] = $email;
                $token_data['userRole'] = "Admin";
                $tokenData = $this->authorization_token->generateToken($token_data);
                return $this->sendJson(array("token" => $tokenData, "status" => true, "response" => "Login Success!"));
            } else {
                return $this->sendJson(array("token" => null, "status" => false, "response" => "Login Failed!"));
            }
        } else {
            return $this->sendJson(array("message" => "POST Method", "status" => false));
        }
    }

    private function sendJson($data)
    {
        $this->output->set_header('Content-Type: application/json; charset=utf-8')->set_output(json_encode($data));
    }
}