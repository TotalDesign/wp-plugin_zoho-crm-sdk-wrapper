# Zoho CRM SDK Wrapper

A simple WordPress plugin integrating the [Zoho CRM PHP SDK](https://github.com/zoho/zcrm-php-sdk) with WordPress.

## Capabilities

This plugin integrates with WP-CLI in order to easily setup tokens necessary for authenticating to the Zoho API by means
of the Zoho CRM PHP SDK.

It will also handle initialization of the Zoho CRM SDK upon the WordPress `init` hook.

## Prerequisites

This plugin is developed with a WordPress [Bedrock](https://github.com/roots/bedrock) installation into mind. The Zoho 
CRM tokens will be stored in the /config directory. Configuration is done by means of environment variables.

## Configuration

The following environment variables are required:

- `ZOHO_CLIENT_ID`
- `ZOHO_CLIENT_SECRET`
- `ZOHO_CURRENT_USER_EMAIL`
- `ZOHO_REDIRECT_URI`

The following environment variables are optional:

- `ZOHO_ACCOUNTS_URL` defaults to `https://accounts.zoho.com`
- `ZOHO_API_BASE_URL` defaults to `www.zohoapis.com`
- `ZOHO_SANDBOX` defaults to `false`
- `ZOHO_CONFIG_PATH` defaults to Bedrock's `/config` directory

## Initialization: the Self-Client Method

For more information on the Zoho CRM PHP SDK initialization please check out its documentation at https://www.zoho.com/crm/developer/docs/php-sdk/initialize.html.

In order to be able to use the Zoho CRM SDK in WordPress you need to register a set of OAuth tokens by means of the 
built-in WP-CLI command. The `%grant-token%` should be replaced by the temporary token you receive from the Zoho 
Developer Console.

```
wp zoho grant-token %grant-token%
```
