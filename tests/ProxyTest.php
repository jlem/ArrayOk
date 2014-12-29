<?php

use Jlem\ArrayOk\Proxy;
use Jlem\ArrayOk\ArrayOk;

class ProxyTest extends PHPUnit_Framework_Testcase
{
    protected function setUp()
    {
        require_once '../src/Proxy.php';
        require_once '../src/ArrayOk.php';
    }

    public function testFlip()
    {
        $input = array(
            'yoda' => 'master',
            'luke' => 'jedi',
            'vader' => 'sith'
        );

        $expected = array(
            'master' => 'yoda',
            'jedi' => 'luke',
            'sith' => 'vader'
        );

        $output = Proxy::flip($input);

        $this->assertSame($expected, $output->items);
    }

    public function testReplace()
    {
        $initial = array(
            'yoda' => 0,
            'luke' => 1,
            'vader' => 2
        );

        $replacement = array(
            'luke' => 'jedi',
            'vader' => 'sith',
            'yoda' => 'master'
        );

        $expected = array(
            'yoda' => 'master',
            'luke' => 'jedi',
            'vader' => 'sith'
        );

        $output = Proxy::replace($initial, $replacement);

        $this->assertSame($expected, $output->items);
    }


    public function testIntersectKeys()
    {
        $initial = array(
            'luke' => 'jedi',
            'vader' => 'sith',
            'yoda' => 'master'
        );

        $intersect = array(
            'yoda' => 0,
            'luke' => 1,
        );

        $expected = array(
            'luke' => 'jedi',
            'yoda' => 'master'
        );

        $output = Proxy::intersectKeys($initial, $intersect);

        $this->assertSame($expected, $output->items);
    }

    public function testCut()
    {
        $initial = array(
            'luke' => 'jedi',
            'vader' => 'sith',
            'yoda' => 'master'
        );

        $cut = array('vader', 'yoda');

        $expected = array(
            'vader' => 'sith',
            'yoda' => 'master'
        );

        $output = Proxy::cut($initial, $cut);

        $this->assertSame($expected, $output->items);
    }

    public function testOrderWithoutCut()
    {
        $initial = array(
            'luke' => 'jedi',
            'vader' => 'sith',
            'yoda' => 'master'
        );

        $sequence = array('vader', 'luke', 'yoda');

        $expected = array(
            'vader' => 'sith',
            'luke' => 'jedi',
            'yoda' => 'master'
        );

        $actual = Proxy::order($initial, $sequence, false);

        $this->assertSame($expected, $actual->items);
    }

    public function testOrderWithoutCutAndShortSequence()
    {
        $initial = array(
            'luke' => 'jedi',
            'vader' => 'sith',
            'yoda' => 'master'
        );

        $sequence = array('yoda', 'luke');

        $expected = array(
            'yoda' => 'master',
            'luke' => 'jedi',
            'vader' => 'sith'
        );

        $actual = Proxy::order($initial, $sequence, false);

        $this->assertSame($expected, $actual->items);
    }

    public function testOrderWithCut()
    {
        $initial = array(
            'luke' => 'jedi',
            'vader' => 'sith',
            'yoda' => 'master'
        );

        $sequence = array('yoda', 'luke');

        $expected = array(
            'yoda' => 'master',
            'luke' => 'jedi'
        );

        $actual = Proxy::order($initial, $sequence);

        $this->assertSame($expected, $actual->items);
    }
}
