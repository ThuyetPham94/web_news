<?php
namespace App\Http\Services;

use \Facebook\Facebook;

class FacebookService {

    function getProfile($access_token) {
        $fb = new \Facebook\Facebook([
            'app_id' => env('APP_ID'),
            'app_secret' => env('APP_SECRET'),
            'default_graph_version' => 'v2.10',
        ]);

        try {
            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/me?fields=id,first_name,last_name,middle_name,picture,email', $access_token);
            $me = $response->getGraphUser();
            $data = array();
            if ($me->getId()) {
                $data['id'] = $me->getId();
            }
            if ($me->getEmail()) {
                $data['email'] = $me->getEmail();
            }
            if ($me->getFirstName()) {
                $data['first_name'] = $me->getFirstName();
            }
            if ($me->getLastName()) {
                $data['last_name'] = $me->getLastName();
            }
            if ($me->getPicture()) {
                $data['picture'] = $me->getPicture()['url'];
            }
            return $data;
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            return;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return;
        }
    }
}