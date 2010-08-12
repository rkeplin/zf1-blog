<?php
interface Model_Mapper_QuoteInterface
{
    public function save(Model_Quote $quote);
    public function getQuote();
    public function getPaged($page = 1);
}