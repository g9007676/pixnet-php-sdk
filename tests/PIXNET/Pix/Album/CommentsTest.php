<?php
class Pix_Album_commentsTest extends PHPUnit_Framework_TestCase
{
    public static $pixapi;
    public static $test_set;

    public static function setUpBeforeClass()
    {
        Authentication::setUpBeforeClass();
        self::$pixapi = Authentication::$pixapi;
        self::$test_set = self::$pixapi->Album->Sets->search('emmatest')[0];
    }

    private function createTempComments()
    {
        $comments = [];
        for ($i = 0; $i < 5; $i++) {
            $comments[$i] = self::$pixapi->Album->comments->create('emmatest', self::$test_set['id'], 'test message');
            echo "create " . $comments[$i]['id'] . PHP_EOL;
        }
        return $comments;
    }

    private function destoryTempComments($comments)
    {
        foreach ($comments as $c) {
            self::$pixapi->Album->comments->delete($c['id']);
            echo "delete " . $c['id'] . PHP_EOL;
        }
    }
}