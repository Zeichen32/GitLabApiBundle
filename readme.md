Getting Started With Zeichen32GitLabApiBundle
=========================================

[![Build Status](https://travis-ci.org/Zeichen32/GitLabApiBundle.svg)](https://travis-ci.org/Zeichen32/GitLabApiBundle)

This Bundle integrates the [GitLab PHP API Client](https://github.com/GitLabPHP/Client) into your Symfony Project.


### Step 1: Install Zeichen32GitLabApiBundle

The preferred way to install this bundle is to rely on [Composer](https://getcomposer.org).

``` js
{
    "require": {
        // ...
        "guzzlehttp/guzzle:^7.0.1",  // Optional PSR Client, if you dont want to use the symfony http client
        "zeichen32/gitlabapibundle": "~5.0"
    }
}
```

### Step 2: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Zeichen32\GitLabApiBundle\Zeichen32GitLabApiBundle(),
    );
}
```

### Step 3: Configure Zeichen32GitLabApiBundle

Add Zeichen32GitLabApiBundle settings in app/config/config.yml:


``` yaml
zeichen32_git_lab_api:
    clients:
        firstclient:
            token: your-api-token
            url: http://example.org/api/v3/
            auth_method: http_token
        secondclient:
            token: your-api-token
            url: http://example.org/api/v3/
            auth_method: oauth_token
            sudo: 1
        thirdclient:
            token: your-api-token
            url: http://example.org/api/v3/
            alias: custom_alias
```

The first client automatically defined as your default client.

### Step 4: Use the gitlab api

If you want to use the default client you can use type hinting.

``` php
<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Gitlab\Client;

class DefaultController extends AbstractController {
    public function index(Client $client) {
        $issues = $client->api('issues')->all($project_id);
    }
}
```

If you want to get one of the other clients, you can get the specific client
by the "zeichen32_gitlabapi.client.CLIENT_NAME" service id.

``` yaml
services:
    App\Controller\DefaultController:
        arguments: {$client: '@zeichen32_gitlabapi.client.default'}
```
``` php
<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Gitlab\Client;

class DefaultController extends AbstractController {
    private $client;

    public __construct(Client $client) {
        $this->client = $client;
    }

    public function index() {
        $issues = $this->client->api('issues')->all($project_id);
    }
}

```

Or if you set alias option:

``` yaml
services:
    App\Controller\DefaultController:
        arguments: {$client: '@custom_alias'}
```

For more information about using the api, take a look at the [GitLab Client Documentation](https://github.com/GitLabPHP/Client).

### Step 5: Configuration Reference

All available configuration options with their default values listed below:

``` yaml

zeichen32_git_lab_api:
    clients:              # Required
        token:                ~ # Required
        url:                  ~ # Required
        auth_method:          ~ http_token|oauth_token
        sudo:                 ~
        alias:                ~
        http_client:          ~ # http client service id

```

### License

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE
