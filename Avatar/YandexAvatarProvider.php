<?php

namespace Kanboard\Plugin\OAuth2Yandex\Avatar;

use Kanboard\Core\Base;
use Kanboard\Core\User\Avatar\AvatarProviderInterface;
use Pimple\Container;

/**
 * Yandex Avatar Provider
 *
 * @package  Kanboard\Avatar
 * @author   Roman Grinevich
 */
class YandexAvatarProvider extends Base implements AvatarProviderInterface
{
    /**
     * Render avatar html
     *
     * @access public
     * @param  array $user
     * @param  int   $size
     * @return string
     */
    public function render(array $user, $size)
    {
        $db = $this->container->db;
        $email = $user['email'];
        
        $url = '';
        
        $r = $db->table('oauth2yandex_avatar')->select('avatar')->eq('email', $email)->findOne();
        $av_code = $r['avatar'];
        $url = 'https://avatars.yandex.net/get-yapic/'.$av_code.'/';
        
        if ($size <= 28) {
            $name = 'islands-small';
        } elseif ($size <= 34) {
            $name = 'islands-34';
        } elseif ($size <= 42) {
            $name = 'islands-middle';
        } elseif ($size <= 50) {
            $name = 'islands-50';
        } elseif ($size <= 56) {
            $name = 'islands-retina-small';
        } elseif ($size <= 68) {
            $name = 'islands-68';
        } elseif ($size <= 75) {
            $name = 'islands-75';
        } elseif ($size <= 84) {
            $name = 'islands-retina-middle';
        } elseif ($size <= 100) {
            $name = 'islands-retina-50';
        } elseif ($size <= 200) {
            $name = 'islands-200';
        } else {
            $name = 'islands-300';
        }
        
        $url = $url.$name;
        $title = $this->helper->text->e($user['name'] ?: $user['username']);
        return '<img src="'.$url.'" alt="'.$title.'" title="'.$title.'">';
    }

    /**
     * Determine if the provider is active
     *
     * @access public
     * @param  array $user
     * @return boolean
     */
    public function isActive(array $user)
    {
        if (!empty($user['email'])) {
            $db = $this->container->db;
            $email = $user['email'];
            
            return ($db->table('oauth2yandex_avatar')->eq('email', $email)->exists());
        }
        
        return false;
    }
}