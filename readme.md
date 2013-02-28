Getting Started With Zeichen32GitLabApiBundle
=========================================

### Step 1: Install Zeichen32GitLabApiBundle

The preferred way to install this bundle is to rely on [Composer](http://getcomposer.org).

``` js
{
    "require": {
        // ...
        "zeichen32/gitlabapibundle": "dev-master"
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
            url: http://your-gitlab-url.com/api/v3/

        secondclient:
            token: your-api-token
            url: http://your-gitlab-url.com/api/v3/
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

### Step 4: Use the gitlab issue tracker in your application (optional)


Import the routing.yml configuration file in app/config/routing.yml:

``` yaml
# app/config/routing.yml
zeichen32_git_lab_api:
    resource: "@Zeichen32GitLabApiBundle/Resources/config/routing/issues.xml"
    prefix:   /issue
```

Add Zeichen32GitLabApiBundle settings in app/config/config.yml:

``` yaml
# app/config/config.yml
zeichen32_git_lab_api:
    # ...
    issue_tracker:
        project: your-project-id
        client: your-client-name [optional]
```



