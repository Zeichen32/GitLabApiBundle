Getting Started With Zeichen32GitLabApiBundle
=========================================

[![Build Status](https://travis-ci.org/Zeichen32/GitLabApiBundle.svg)](https://travis-ci.org/Zeichen32/GitLabApiBundle)

This Bundle integrate the [Gitlab API Wrapper](https://github.com/m4tthumphrey/php-gitlab-api) into your Symfony2 Project.

Attention:
I have refactor the whole bundle and have remove the issue tracker to decouple the issue tracker from the bundle.
The old version with the issue tracker is still available in the 1.0.x Branche

### Step 1: Install Zeichen32GitLabApiBundle

The preferred way to install this bundle is to rely on [Composer](http://getcomposer.org).

``` js
{
    "require": {
        // ...
        "zeichen32/gitlabapibundle": "~3.0"
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
            auth_method: url_token
        secondclient:
            token: your-api-token
            url: http://example.org/api/v3/
            auth_method: http_token
            sudo: 1
        thirdclient:
            token: your-api-token
            url: http://example.org/api/v3/
            alias: custom_alias
```

The first client is defined automatically as your default client.

### Step 4: Use the gitlab api

If you want to use the default client, you can easy getting the client
by the "gitlab_api" service-id.

``` php
        $api = $this->get('gitlab_api');
        $issues = $api->api('issues')->all($project_id);

```

If you want to get one of the other clients, you can getting the specific client
by the "zeichen32_gitlabapi.client.CLIENT_NAME" service id.

``` php
        $api = $this->get('zeichen32_gitlabapi.client.secondclient');
        $issues = $api->api('issues')->all($project_id);

```

Or if you set alias option:

``` php
        $api = $this->get('custom_alias');
        $issues = $api->api('issues')->all($project_id);

```

For more information about using the api, take a look at the [Gitlab Client Documentation](https://github.com/m4tthumphrey/php-gitlab-api).

### Step 5: Configuration Reference

All available configuration options are listed below with their default values.

``` yaml

zeichen32_git_lab_api:
    clients:              # Required
        token:                ~ # Required
        url:                  ~ # Required
        auth_method:          ~ http_token|url_token|oauth_token
        sudo:                 ~
        alias:                ~
        http_client:          ~ # http plug client service id

```

### License

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE
