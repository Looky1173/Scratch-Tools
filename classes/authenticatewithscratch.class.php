<?php

/*
This file is responsible for generating and verifying Scratch authentication codes.
*/

class AuthenticateWithScratch extends Db {
    public function checkValidScratchAccount($username) {
        //Check if the requested Scratch account exists
        $response = file_get_contents("https://api.scratch.mit.edu/accounts/checkusername/" . $username);
        $response = json_decode($response);
        return $response->msg;
    }
    public function generateAuthenticationCode($keyLength) {
        //return bin2hex(random_bytes(16));
        $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ()$/.,?!";
        $randStr = substr(str_shuffle($str), 0, $keyLength);
        return $randStr;
    }
    public function authenticate($requested_user, $verification_code) {
        $projectId = 440802985;
        $project_url = 'http://scratch.mit.edu/projects/' . $projectId;
        $api_url = 'http://scratch.mit.edu/site-api/comments/project/' . $projectId . '?page=1&salt=' . md5(time()); //salt is to prevent caching
        $data = file_get_contents($api_url);
            if (!$data) {
                return '<p>API access failed. Please try again later.</p>';
            }
            preg_match_all('%<div id="comments-\d+" class="comment.*?" data-comment-id="\d+">.*?<a href="/users/(.*?)".*?<div class="content">(.*?)</div>%ms', $data, $matches);
            foreach ($matches[2] as $key => $val) {
                $user = $matches[1][$key];
                $comment = trim($val);
                if ($user == $requested_user && $comment == $verification_code) {
                    return "true";
                    break;
                }
            }
    }
}