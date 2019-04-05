<?php

namespace Kanboard\Plugin\OAuth2Yandex\Controller;

use Kanboard\Controller\OAuthController as BaseOAuthController;

/**
 * OAuth Controller
 *
 * @package  Kanboard\Controller
 * @author   Roman Grinevich
 */
class OAuthController extends BaseOAuthController
{
    /**
     * Handle authentication
     *
     * @access public
     */
    public function handler()
    {
        try {
            $this->step1('OAuth2Yandex');
        } catch (Exception $e) {
            echo($e->getMessage());
        }
    }
}
