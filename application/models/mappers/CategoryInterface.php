<?php
interface Model_Mapper_CategoryInterface
{
    public function save(Model_Category $category);
    public function getCategory($id);
    public function fetchAll($is_published);
}