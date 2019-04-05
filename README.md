OAuth2Yandex Authentication
=====================

Generic OAuth2Yandex authentication plugin.

Author
------

- Roman Grinevich
- License MIT

Requirements
------------

- Kanboard >= 1.0.37

Installation
------------

You have the choice between 3 methods:

1. Install the plugin from the Kanboard plugin manager in one click
2. Download the zip file and decompress everything under the directory `plugins/OAuth2Yandex`
3. Clone this repository into the folder `plugins/OAuth2Yandex`

Note: Plugin folder is case-sensitive.

Configuration
-------------

Go to the application settings > integrations > OAuth2Yandex Authentication.

### 1) Create a new application on the OAuth2Yandex provider

Go to the third-party authentication provider and add a new application. 
Copy and paste the **Kanboard callback URL** and generate a new set of tokens.

The third-party provider will returns a **Client ID** and a **Client Secret**.
Copy those values in the Kanboard's settings.

### 2) Configure the provider in Kanboard

- **Client ID**: Unique ID that comes from the third-party provider
- **Client Secret**: Unique token that comes from the third-party provider

