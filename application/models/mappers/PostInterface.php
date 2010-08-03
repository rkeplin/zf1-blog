<?php
interface Model_Mapper_PostInterface
{
    public function save(Model_Post $post);
    public function getRssFeed();
    public function query($data, $page);
    public function getFromTitle($title);
    public function fetchLatest();
    public function getPost($id, $is_published);
    public function fetchValidYears();
    public function getRecentPosts($limit);
    public function delete(Model_Post $post);
    public function getFromCategory($category, $page);
    public function getFromArchive($year, $page);
    public function getPagedTitles($page);
}