<?php

namespace Kanboard\Plugin\OAuth2Yandex\User;

use Kanboard\Core\Base;
use Kanboard\Core\User\UserProviderInterface;
use Pimple\Container;

/**
 * GenericOAuth2UserProvider
 *
 * @package  Kanboard\User
 * @author   Roman Grinevich
 */
class GenericOAuth2UserProvider extends Base implements UserProviderInterface
{
    /**
     * @var array
     */
    protected $userData = array();

    /**
     * Constructor
     *
     * @access public
     * @param  Container $container
     * @param  array $user
     */
    public function __construct(Container $container, array $user)
    {
        parent::__construct($container);
        $this->container = $container;
        $this->userData = $user;
    }

    /**
     * Return true to allow automatic user creation
     *
     * @access public
     * @return boolean
     */
    public function isUserCreationAllowed()
    {
        if ($this->configModel->get('oauth2yandex_account_creation', 0) != 1) {
            return false;
        }
        
        $domains = $this->configModel->get('oauth2yandex_email_domains');
        if (! empty($domains)) {
            return $this->validateDomainRestriction($this->getKey('default_email'), $domains);
        }
        
        return true;
    }

    /**
     * Get username
     *
     * @access public
     * @return string
     */
    public function getUsername()
    {
        if ($this->isUserCreationAllowed()) {
            return str_replace('@', '_', $this->getKey('login'));
        }

        return '';
    }

    /**
     * Get external id column name
     *
     * @access public
     * @return string
     */
    public function getExternalIdColumn()
    {
        return 'oauth2yandex_user_id';
    }

    /**
     * Get extra user attributes
     *
     * @access public
     * @return array
     */
    public function getExtraAttributes()
    {
        if ($this->isUserCreationAllowed()) {
            return array(
                'is_ldap_user' => 1,
                'disable_login_form' => 1,
            );
        }

        return array();
    }

    /**
     * Get internal id
     *
     * If a value is returned the user properties won't be updated in the local database
     *
     * @access public
     * @return integer
     */
    public function getInternalId()
    {
        return '';
    }

    /**
     * Get external id
     *
     * @access public
     * @return string
     */
    public function getExternalId()
    {
        return $this->getKey('id');
    }

    /**
     * Get user role
     *
     * Return an empty string to not override role stored in the database
     *
     * @access public
     * @return string
     */
    public function getRole()
    {
        return '';
    }

    /**
     * Get user full name
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return $this->getKey('real_name');
    }

    /**
     * Get user email
     *
     * @access public
     * @return string
     */
    public function getEmail()
    {
        $av_exists = $this->getKey('is_avatar_empty');
        $av_code = $this->getKey('default_avatar_id');
        $email = $this->getKey('default_email');
        $db = $this->container->db;
        
        $db->table('oauth2yandex_avatar')->eq('email', $email)->remove();
        
        if ($av_exists == false) {
            $db->table('oauth2yandex_avatar')->insert(['email' => $email, 'avatar' => $av_code]);
        }
        
        return $email;
    }

    /**
     * Get external group ids
     *
     * A synchronization is done at login time,
     * the user will be member of those groups if they exists in the database
     *
     * @access public
     * @return string[]
     */
    public function getExternalGroupIds()
    {
        return array();
    }

    /**
     * Return true if the account creation is allowed according to the settings
     *
     * @access public
     * @param array $profile
     * @return bool
     */
    public function isAccountCreationAllowed(array $profile)
    {
        if (strpos($profile['email'], '@gosreforma.ru') > 0) {
            return true;
        }
        return false;

        if ($this->isUserCreationAllowed()) {
            $domains = $this->configModel->get('oauth2yandex_email_domains');

            if (! empty($domains)) {
                return $this->validateDomainRestriction($profile['email'], $domains);
            }

            return true;
        }

        return false;
    }

    /**
     * Validate domain restriction
     *
     * @access private
     * @param  string $email
     * @param  string $domains
     * @return bool
     */
    public function validateDomainRestriction($email, $domains)
    {
        foreach (explode(',', $domains) as $domain) {
            $domain = trim($domain);

            if (strpos($email, $domain) > 0) {
                return true;
            }
        }

        return false;
    }

    protected function getKey($key)
    {
        return ! empty($key) && isset($this->userData[$key]) ? $this->userData[$key] : '';
    }
}
