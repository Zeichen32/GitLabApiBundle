<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jens
 * Date: 25.02.13
 * Time: 11:30
 * To change this template use File | Settings | File Templates.
 */

namespace Zeichen32\GitLabApiBundle;


class Events {
    const ISSUE_CREATE_INIT     = 'gitlabapi_issue_create_before';
    const ISSUE_CREATE_PRESAVE  = 'gitlabapi_issue_create_presave';
    const ISSUE_CREATE_POSTSAVE = 'gitlabapi_issue_create_postsave';
}