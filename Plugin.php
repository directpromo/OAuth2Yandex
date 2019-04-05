<?php

namespace Kanboard\Plugin\OAuth2Yandex;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Security\Role;
use Kanboard\Core\Translator;
use Kanboard\Plugin\OAuth2Yandex\Auth\GenericOAuth2Provider;
use Kanboard\Plugin\OAuth2Yandex\Avatar\YandexAvatarProvider;

class Plugin extends Base
{
    public function initialize()
    {
        $this->container->db = $this->db;
        
        $this->authenticationManager->register(new GenericOAuth2Provider($this->container));
        $this->applicationAccessMap->add('OAuthController', 'handler', Role::APP_PUBLIC);

        $this->route->addRoute('/oauth/callback', 'OAuthController', 'handler', 'OAuth2Yandex');

        $this->template->hook->attach('template:auth:login-form:after', 'OAuth2Yandex:auth/login');
        $this->template->hook->attach('template:config:integrations', 'OAuth2Yandex:config/integration');
        $this->template->hook->attach('template:user:authentication:form', 'OAuth2Yandex:user/authentication');
        
        $this->avatarManager->register(new YandexAvatarProvider($this->container));
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'OAuth2Yandex';
    }

    public function getPluginDescription()
    {
        return t('Generic OAuth2Yandex authentication plugin');
    }

    public function getPluginAuthor()
    {
        return 'Roman Grinevich';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://OAuth2Yandex';
    }

    public function getCompatibleVersion()
    {
        return '>=1.0.0';
    }
}

