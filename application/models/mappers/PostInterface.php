<?php
interface Model_Mapper_PostInterface
{
    public function save(Model_Post $post);
    public function getRssFeed();
    public function query($data, $page = 1);
    public function getFromTitle($title);
    public function fetchLatest();
    public function getPost($id, $is_published = 1);
    public function fetchValidYears();
    public function getRecentPosts($limit);
    public function delete(Model_Post $post);
    public function getFromCategory($category, $page = 1);
    public function getFromArchive($year, $page = 1);
    public function getPagedTitles($page = 1);
}