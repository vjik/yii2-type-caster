<?php

namespace vjik\yii2\typeCasterTests\request;

use PHPUnit\Framework\TestCase;
use vjik\yii2\typeCaster\request\A;
use vjik\yii2\typeCaster\request\RequestTrait;
use yii\web\BadRequestHttpException;

class RequestTraitTest extends TestCase
{

    protected $trait;

    protected function setUp(): void
    {
        $this->trait = $this->getMockForTrait(RequestTrait::class);
    }

    public function testBase()
    {
        $trait = $this->trait;
        $trait->method('get')->with('param', null)->willReturn(1);
        $trait->method('post')->with('param', null)->willReturn(0);

        /** @var $trait RequestTrait */
        $this->assertSame($trait->fromGet('param')->getValue(), 1);
        $this->assertSame($trait->fromGet('param')->getBool(), true);
        $this->assertSame($trait->fromGet('param')->getInt(), 1);
        $this->assertSame($trait->fromGet('param')->getFloat(), 1.0);
        $this->assertSame($trait->fromGet('param')->getString(), '1');
        $this->assertSame($trait->fromGet('param')->getBoolOrNull(), true);
        $this->assertSame($trait->fromGet('param')->getIntOrNull(), 1);
        $this->assertSame($trait->fromGet('param')->getFloatOrNull(), 1.0);
        $this->assertSame($trait->fromGet('param')->getStringOrNull(), '1');

        $this->assertSame($trait->fromPost('param')->getValue(), 0);
        $this->assertSame($trait->fromPost('param')->getBool(), false);
        $this->assertSame($trait->fromPost('param')->getInt(), 0);
        $this->assertSame($trait->fromPost('param')->getFloat(), 0.0);
        $this->assertSame($trait->fromPost('param')->getString(), '0');
        $this->assertSame($trait->fromPost('param')->getBoolOrNull(), false);
        $this->assertSame($trait->fromPost('param')->getIntOrNull(), 0);
        $this->assertSame($trait->fromPost('param')->getFloatOrNull(), 0.0);
        $this->assertSame($trait->fromPost('param')->getStringOrNull(), '0');
    }

    public function testNull()
    {
        $trait = $this->trait;
        $trait->method('get')->with('param', null)->willReturn(null);

        /** @var $trait RequestTrait */
        $this->assertNull($trait->fromGet('param')->getBoolOrNull());
        $this->assertNull($trait->fromGet('param')->getIntOrNull());
        $this->assertNull($trait->fromGet('param')->getFloatOrNull());
        $this->assertNull($trait->fromGet('param')->getStringOrNull());
    }

    public function testRequire()
    {
        $trait = $this->trait;

        /** @var $trait RequestTrait */
        $this->expectException(BadRequestHttpException::class);
        $trait->fromGet('param')->required()->getValue();
    }

    public function testDefault()
    {
        $trait = $this->trait;

        /** @var $trait RequestTrait */
        $this->assertSame($trait->fromGet('param')->default(42)->getValue(), 42);
    }
}
