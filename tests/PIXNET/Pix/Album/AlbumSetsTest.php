<?php
class Pix_Album_SetsTest extends PHPUnit_Framework_TestCase
{
    public static $pixapi;

    public static function setUpBeforeClass()
    {
        Authentication::setUpBeforeClass();
        self::$pixapi = Authentication::$pixapi;
    }

    /**
     * 產生測試用的相簿
     */
    private function createTempSets()
    {
        for ($i = 0; $i < 5; $i++) {
            $title = "PHP-SDK-TEST-TITLE-" . sha1($i);
            $desc = "PHP-SDK-TEST-DESC-" . md5($i);
            $expected[] = self::$pixapi->album->sets->create($title, $desc);
        }
        return $expected;
    }

    /**
     * 刪除測試用的相簿
     */
    private function destoryTempSets($sets)
    {
        foreach ($sets as $set) {
            self::$pixapi->album->sets->delete($set['id']);
        }
    }

    public static function tearDownAfterClass()
    {
        Authentication::tearDownAfterClass();
    }

    public function testcreate()
    {
        for ($i = 0; $i < 5; $i++) {
            $title = "PHP-SDK-TEST-TITLE-" . sha1($i);
            $desc = "PHP-SDK-TEST-DESC-" . md5($i);
            $ret = self::$pixapi->album->sets->create($title, $desc);
            $this->assertEquals($title, $ret['title']);
            $this->assertEquals($desc, $ret['description']);
            self::$pixapi->album->sets->delete($ret['id']);
        }
    }

    public function testposition()
    {
        $current_albumsets = self::$pixapi->Album->sets->search('emmatest', ['parent_id' => 4948779]);
        $num_of_sets = count($current_albumsets);
        $i = 1;
        foreach ($current_albumsets as $set) {
            $new_order[$i++%$num_of_sets] = $set['id'];
        }
        ksort($new_order);
        $expected = $new_order;
        $ret_albumsets = self::$pixapi->Album->sets->position('4948779', implode(',', $new_order));
        foreach ($ret_albumsets as $set) {
            $actual[] = $set['id'];
        }
        $this->assertEquals($actual, $expected);
    }
    public function testsearch()
    {

        $tempSets = $this->createTempSets();
        foreach ($tempSets as $set) {
            $expected['title'][] = $set['title'];
            $expected['id'][] = $set['id'];
        }
        $actual = self::$pixapi->Album->Sets->search('emmatest');
        foreach ($actual as $set) {
            $this->assertTrue(in_array($set['title'], $expected['title']));
        }

        foreach ($expected['id'] as $set_id) {
            $ret = self::$pixapi->album->sets->search('emmatest', ['set_id' => $set_id]);
            $this->assertEquals($set_id, $ret['id']);
        }

        $this->destoryTempSets($tempSets);
    }
}
