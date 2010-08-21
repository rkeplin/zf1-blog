<?php
class Zend_View_Helper_AdminLinks extends Zend_View_Helper_Abstract
{
    public function adminLinks()
    {
        return '
        <div class="breadcrumbs">
            <a title="admin home" href="/admin/">Admin Home</a> |
            <a title="create post" href="/admin/create-post/">Create Post</a> |
            <a title="view comments" href="/admin/comments/">Manage Comments</a> |
            <a title="download log" href="/admin/download-log/">Download Log</a> |
            <a title="delete log" href="/admin/delete-log/">Delete Log</a> |
            <a title="log out" href="/admin/logout/">Logout</a>
        </div>
        ';
    }
}