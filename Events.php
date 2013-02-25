<?php
namespace Zeichen32\GitLabApiBundle;


class Events {
    const ISSUE_CREATE_INIT     = 'gitlabapi_issue_create_before';
    const ISSUE_CREATE_PRESAVE  = 'gitlabapi_issue_create_presave';
    const ISSUE_CREATE_POSTSAVE = 'gitlabapi_issue_create_postsave';
}