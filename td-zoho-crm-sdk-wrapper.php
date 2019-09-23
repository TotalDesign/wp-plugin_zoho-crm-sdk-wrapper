<?php
/*
Plugin Name:  Zoho CRM SDK Wrapper
Description:  Helps with initializing the Zoho CRM PHP SDK in WordPress via WP CLI.
Version:      0.1.0
Author:       Total Design
Author URI:   https://www.totaldesign.com/
License:      MIT License
*/

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\utility\APIConstants;
use zcrmsdk\oauth\utility\ZohoOAuthConstants;
use zcrmsdk\oauth\ZohoOAuth;

call_user_func(function () {
    $config = [
        ZohoOAuthConstants::IAM_URL => getenv('ZOHO_ACCOUNTS_URL') ?: 'https://accounts.zoho.com',
        APIConstants::API_BASEURL => getenv('ZOHO_API_BASE_URL') ?: 'www.zohoapis.com',
        ZohoOAuthConstants::CLIENT_ID => getenv('ZOHO_CLIENT_ID'),
        ZohoOAuthConstants::CLIENT_SECRET => getenv('ZOHO_CLIENT_SECRET'),
        APIConstants::CURRENT_USER_EMAIL => getenv('ZOHO_CURRENT_USER_EMAIL'),
        ZohoOAuthConstants::REDIRECT_URL => getenv('ZOHO_REDIRECT_URI'),
        ZohoOAuthConstants::SANDBOX => getenv('ZOHO_SANDBOX') ?: false,
        ZohoOAuthConstants::TOKEN_PERSISTENCE_PATH => getenv('ZOHO_CONFIG_PATH') ?: dirname(ABSPATH, 2) . '/config',
    ];

    if (class_exists('WP_CLI_Command')) {
        \WP_CLI::add_command('zoho grant-token', function ($args) use ($config) {
            ZCRMRestClient::initialize($config);
            touch(ZohoOAuth::getConfigValue(ZohoOAuthConstants::TOKEN_PERSISTENCE_PATH) . '/zcrm_oauthtokens.txt');
            /** @var \zcrmsdk\oauth\ZohoOAuthClient $oAuthClient */
            $oAuthClient = ZohoOAuth::getClientInstance();

            try {
                $oAuthClient->generateAccessToken(isset($args['0']) ? $args['0'] : null);

                \WP_CLI::success('Successfully retrieved tokens.');
            } catch (\Exception $e) {
                \WP_CLI::error($e->getMessage());
            }
        });
    }

    add_action('init', function () use ($config) {
        ZCRMRestClient::initialize($config);
    });
});
