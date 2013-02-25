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
    token: your-api-token
    url: your-gitlab-url
    project: your-project-id
```



