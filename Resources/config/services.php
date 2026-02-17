<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $container->parameters()
        ->set('zeichen32_gitlabapi.client.class', 'Gitlab\\Client');

    $container->services()
        ->alias('gitlab_api', 'zeichen32_gitlabapi.client.default')
        ->public();
};
