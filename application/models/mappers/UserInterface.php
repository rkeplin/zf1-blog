<?php
interface Model_Mapper_UserInterface
{
    public function setUser(Model_User $user);
    public function save(Model_User $user);
    public function login(Model_User $user);
    public function getUser($id);
    public function getUserByEmail($email);
    public function getPagedUsers($page);
}