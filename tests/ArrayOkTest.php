<?php

use Jlem\ArrayOk\Proxy;
use Jlem\ArrayOk\ArrayOk;

class ArrayOkTest extends PHPUnit_Framework_Testcase
{
    protected function setUp()
    {
        require_once '../src/Proxy.php';
        require_once '../src/ArrayOk.php';
    }

    public function testRecursiveConstructCreatesSimpleArray()
    {
        $actual = array(
            'yoda' => 'master',
            'luke' => 'jedi',
            'vader' => 'sith'
        );

        $expected = $actual;

        $output = new ArrayOk($actual);
        $output = $output->items;

        $this->assertSame($expected, $output);
    }

    public function testRecursiveConstructCreatesNestedArrayOk()
    {
        $actual = array(
            'jedi' => array(
                'yoda', 'luke', 'obiwan'
            ),
            'sith' => array(
                'maul', 'vader', 'sidious'
            )
        );

        $expected = new ArrayOk($actual);

        $jediIsArrayOk = $expected['jedi'] instanceof ArrayOk;
        $sithIsArrayOk = $expected['sith'] instanceof ArrayOk;

        $this->assertTrue($jediIsArrayOk);
        $this->assertTrue($sithIsArrayOk);

        $this->assertSame($actual['jedi'], $expected['jedi']->items);
        $this->assertSame($actual['sith'], $expected['sith']->items);
    }

    public function testFlip()
    {
        $actual = new ArrayOk(array(
            'yoda' => 'master',
            'luke' => 'jedi',
            'vader' => 'sith'
        ));

        $expected = array(
            'master' => 'yoda',
            'jedi' => 'luke',
            'sith' => 'vader'
        );

        $actual->flip();

        $this->assertSame($expected, $actual->items);
    }

    public function testOrderWithoutCut()
    {
        $actual = new ArrayOk(array(
            'luke' => 'jedi',
            'vader' => 'sith',
            'yoda' => 'master'
        ));

        $sequence = array('vader', 'luke', 'yoda');

        $expected = array(
            'vader' => 'sith',
            'luke' => 'jedi',
            'yoda' => 'master'
        );

        $actual->order($sequence, false);

        $this->assertSame($expected, $actual->items);
    }

    public function testOrderWithoutCutAndShortSequence()
    {
        $actual = new ArrayOk(array(
            'luke' => 'jedi',
            'vader' => 'sith',
            'yoda' => 'master'
        ));

        $sequence = array('yoda', 'luke');

        $expected = array(
            'yoda' => 'master',
            'luke' => 'jedi',
            'vader' => 'sith'
        );

        $actual->order($sequence, false);

        $this->assertSame($expected, $actual->items);
    }

    public function testOrderWithCut()
    {
        $actual = new ArrayOK(array(
            'luke' => 'jedi',
            'vader' => 'sith',
            'yoda' => 'master'
        ));

        $sequence = array('yoda', 'luke');

        $expected = array(
            'yoda' => 'master',
            'luke' => 'jedi'
        );

        $actual->order($sequence);

        $this->assertSame($expected, $actual->items);
    }
}
