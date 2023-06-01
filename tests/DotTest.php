<?php

namespace Tests\Ryanwhowe;

use Ryanwhowe\Dot;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DotTest extends TestCase {

    /**
     * @test
     * @dataProvider setDataProvider
     * @param mixed[] $test
     * @param non-empty-string $key
     * @param mixed $value
     * @param mixed[] $expected
     * @return void
     */
    public function set(array $test, $key, $value, $expected) {
        Dot::set($test, $key, $value);
        $this->assertEquals($expected, $test);
    }

    /**
     * @test
     * @dataProvider getDataProvider
     * @param mixed[] $test
     * @param non-empty-string $key
     * @param array|mixed|null $expected
     * @param mixed|null $default
     * @return void
     */
    public function get(array $test, $key, $expected, $default = null) {
        $actual = Dot::get($test, $key, $default, Dot::DEFAULT_DELIMITER);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @dataProvider hasDataProvider
     * @param mixed[] $test
     * @param non-empty-string $key
     * @param bool $expected
     * @param non-empty-string $delimiter
     * @return void
     */
    public function has(array $test, $key, $expected, $delimiter = Dot::DEFAULT_DELIMITER) {
        $actual = Dot::has($test, $key, $delimiter);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @dataProvider flattenDataProvider
     * @param mixed[] $test
     * @param array<non-empty-string, mixed> $expected
     * @return void
     */
    public function flatten(array $test, array $expected) {
        $actual = Dot::flatten($test);
        $this->assertEquals($expected, $actual);

        // There should never be an array value in a flattened response
        foreach ($actual as $value) {
            $this->assertFalse(is_array($value));
        }
    }

    /**
     * @test
     * @dataProvider setDataProvider
     * @param mixed[] $test
     * @param non-empty-string $key
     * @param mixed $value
     * @param mixed[] $expected
     * @return void
     */
    public function setCustomDelimiter(array $test, $key, $value, array $expected) {

        $custom_delimiter = '~';
        $key = str_replace('.', $custom_delimiter, $key);

        Dot::set($test, $key, $value, $custom_delimiter);
        $this->assertEquals($expected, $test);
    }

    /**
     * @test
     * @dataProvider getDataProvider
     * @param mixed[] $test
     * @param non-empty-string $key
     * @param array|mixed|null $expected
     * @param mixed|null $default
     * @return void
     */
    public function getCustomDelimiter(array $test, $key, $expected, $default = null) {
        $custom_delimiter = '~';
        $key = str_replace('.', $custom_delimiter, $key);

        $actual = Dot::get($test, $key, $default, $custom_delimiter);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @dataProvider flattenWithCustomDelimitersDataProvider
     * @param non-empty-string $delimiter
     * @param mixed[] $test
     * @param mixed[] $expected
     * @return void
     */
    public function flattenWithCustomDelimiters($delimiter, array $test, array $expected) {
        $actual = Dot::flatten($test, $delimiter);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @param non-empty-string $deliminator
     * @return void
     * @dataProvider invalidDelimiterDataProvider
     */
    public function getEmptyStringFailure($deliminator) {
        $this->expectException(InvalidArgumentException::class);
        Dot::get([], 'test.test', null, $deliminator);
    }

    /**
     * @test
     * @param non-empty-string $deliminator
     * @return void
     * @dataProvider invalidDelimiterDataProvider
     */
    public function setEmptyStringFailure($deliminator) {
        $this->expectException(InvalidArgumentException::class);
        $test = [];
        Dot::set($test, 'test.test', 'test', $deliminator);
    }

    /**
     * @test
     * @param non-empty-string $deliminator
     * @dataProvider invalidDelimiterDataProvider
     * @return void
     */
    public function hasEmptyStringFailure($deliminator) {
        $this->expectException(InvalidArgumentException::class);
        Dot::has([], 'test.test', $deliminator);
    }

    /**
     * @test
     * @param non-empty-string $deliminator
     * @dataProvider invalidDelimiterDataProvider
     * @return void
     */
    public function flattenEmptyStringFailure($deliminator) {
        $this->expectException(InvalidArgumentException::class);
        Dot::flatten([], $deliminator);
    }

    /**
     * @return string[][]
     */
    public static function popFlattenDataProvider() {
        return [
            'Dot test1' => ['test1', 'test1', ''],
            'Dot test2' => ['test1.test2', 'test2', 'test1'],
            'Dot test3' => ['test1.test2.test3', 'test3', 'test1.test2'],
            'Dot test4' => ['test1.test2.test3.test4', 'test4', 'test1.test2.test3'],
            'Tilda test1' => ['test1', 'test1', '', '~'],
            'Tilda test2' => ['test1~test2', 'test2', 'test1', '~'],
            'Tilda test3' => ['test1~test2~test3', 'test3', 'test1~test2', '~'],
            'Tilda test4' => ['test1~test2~test3~test4', 'test4', 'test1~test2~test3', '~'],

            'Dot 1' => ['1', '1', ''],
            'Dot 2' => ['1.2', '2', '1'],
            'Dot 3' => ['1.2.3', '3', '1.2'],
            'Dot 4' => ['1.2.3.4', '4', '1.2.3'],
            'Tilda 1' => ['1', '1', '', '~'],
            'Tilda 2' => ['1~2', '2', '1', '~'],
            'Tilda 3' => ['1~2~3', '3', '1~2', '~'],
            'Tilda 4' => ['1~2~3~4', '4', '1~2~3', '~'],
        ];
    }

    /**
     * @return mixed[]
     */
    public static function setDataProvider() {
        return [
            'single dimension set' => [['test' => 'test'], 'test', 'new', ['test' => 'new']],
            'single dimension create' => [[], 'test', 'new', ['test' => 'new']],

            'multi dimension set' => [['test' => ['test' => 'test']], 'test.test', 'new', ['test' => ['test' => 'new']]],
            'multi dimension set non key' => [['test' => ['test']], 'test.0', 'new', ['test' => ['new']]],

            'multi dimension create' => [[], 'test.test', 'new', ['test' => ['test' => 'new']]],
            'multi dimension create non key' => [[], 'test.0', 'new', ['test' => ['new']]],

            'multi dimension multi non key set' => [
                ['test' => [['test']]],
                'test.0.0',
                'new',
                ['test' => [['new']]]
            ],
            'multi dimension multi non key create' => [
                [],
                'test.0.0',
                'new',
                ['test' => [['new']]]
            ],
            'multi dimension multi non key create part' => [
                ['test' => []],
                'test.0.0',
                'new',
                ['test' => [['new']]]
            ],

            'multi dimension multi mixed set' => [
                ['test' => [['test' => 'test']]],
                'test.0.test',
                'new',
                ['test' => [['test' => 'new']]]
            ],
            'multi dimension multi mixed create' => [
                [],
                'test.0.test',
                'new',
                ['test' => [['test' => 'new']]]
            ],
            'multi dimension multi mixed create part' => [
                ['test' => ['test']],
                'test.1.test',
                'new',
                ['test' => ['test', ['test' => 'new']]]
            ],
        ];
    }

    /**
     * @return mixed[]
     */
    public static function getDataProvider() {

        $base_search_array = [
            'test1' => [
                'test1' => 'test1.test1'
            ],
            'test2' => [
                'test2' => "\0"
            ],
            'test3' => [
                'int' => 1,
                'float' => 1.1,
                'string' => 'string',
                'true' => true,
                'false' => false,
            ],
            'test4' => [
                [
                    'test4' => ['test4']
                ]
            ],
            'test5' => [
                [
                    'test5' => [
                        ['test5']
                    ]
                ]
            ]
        ];

        return [
            'first level test' => [$base_search_array, 'test1', ['test1' => 'test1.test1']],

            'second level test' => [$base_search_array, 'test1.test1', 'test1.test1'],
            'second level test not' => [$base_search_array, 'test2.test2', "\0"],

            'results type check, int' => [$base_search_array, 'test3.int', 1],
            'results type check, float' => [$base_search_array, 'test3.float', 1.1],
            'results type check, bool true' => [$base_search_array, 'test3.true', true],
            'results type check, bool false' => [$base_search_array, 'test3.false', false],
            'results type check, string' => [$base_search_array, 'test3.string', 'string'],

            'key not found test, default default' => [$base_search_array, 'notthere', null],

            'key not found test, int default' => [$base_search_array, 'notthere', 0, 0],
            'key not found test, false default' => [$base_search_array, 'notthere', false, false],
            'key not found test, true default' => [$base_search_array, 'notthere', true, true],
            'key not found test, float default' => [$base_search_array, 'notthere', 1.1, 1.1],
            'key not found test, string default' => [$base_search_array, 'notthere', 'nonya', 'nonya'],

            'mixed key types' => [$base_search_array, 'test4.0.test4.0', 'test4'],
            'mixed key types multi int' => [$base_search_array, 'test5.0.test5.0.0', 'test5'],
        ];
    }

    /**
     * @return mixed[]
     */
    public static function hasDataProvider() {
        $base_search_array = [
            'test1' => [
                'test1' => 'test1.test1'
            ],
            'test2' => [
                'test2' => "\0"
            ],
            'test3' => [
                'int' => 1,
                'float' => 1.1,
                'string' => 'string',
                'true' => true,
                'false' => false,
            ],
            'test4' => [
                [
                    'test4' => ['test4']
                ]
            ],
            'test5' => [
                [
                    'test5' => [
                        ['test5']
                    ]
                ]
            ]
        ];

        return [
            'single level present' => [$base_search_array, 'test1', true],
            'single level not present' => [$base_search_array, 'notthere', false],

            'multiple level present' => [$base_search_array, 'test1.test1', true],
            'multiple level present custom delim' => [$base_search_array, 'test1~test1', true, '~'],
            'multiple level not present' => [$base_search_array, 'test1.notthere', false],
            'multiple level not present custom delim' => [$base_search_array, 'test1~notthere', false, '~'],
            'multiple level many not present custom delim' => [$base_search_array, 'test1~test1~blah1~blah2~blah3~blah4~blah5', false, '~'],

        ];
    }

    /**
     * @return mixed[]
     */
    public static function flattenDataProvider() {
        return [
            'single item pass through' => [['test' => 'test'], ['test' => 'test']],
            'single nested item' => [['test' => ['test' => 'test']], ['test.test' => 'test']],
            'multi items pass through' => [
                ['test1' => 'test1', 'test2' => 'test2'],
                ['test1' => 'test1', 'test2' => 'test2']
            ],
            'multi nested items' => [
                ['test1' => ['test1' => 'test1'], 'test2' => 'test2'],
                ['test1.test1' => 'test1', 'test2' => 'test2']
            ],
            'multi nested items non string keys' => [
                ['test1' => ['test1' => 'test1'], 'test2' => ['test2']],
                ['test1.test1' => 'test1', 'test2.0' => 'test2']
            ],
            'multi nested items multiple non string keys' => [
                ['test1' => ['test1' => 'test1'], 'test2' => ['test2', 'test2a']],
                ['test1.test1' => 'test1', 'test2.0' => 'test2', 'test2.1' => 'test2a']
            ],
            'deep nested items multiple non string keys' => [
                ['test1' => ['test1' => ['test1' => [['test1']]]], 'test2' => ['test2', 'test2a']],
                ['test1.test1.test1.0.0' => 'test1', 'test2.0' => 'test2', 'test2.1' => 'test2a']
            ],
        ];
    }

    /**
     * @return mixed[]
     */
    public static function flattenWithCustomDelimitersDataProvider() {
        return [
            'single nested item' => ['_', ['test' => ['test' => 'test']], ['test_test' => 'test']],
            'multi nested items' => [
                '--',
                ['test1' => ['test1' => 'test1'], 'test2' => 'test2'],
                ['test1--test1' => 'test1', 'test2' => 'test2']
            ],
            'multi nested items multiple non string keys' => [
                '*',
                ['test1' => ['test1' => 'test1'], 'test2' => ['test2', 'test2a']],
                ['test1*test1' => 'test1', 'test2*0' => 'test2', 'test2*1' => 'test2a']
            ],
            'deep nested items multiple non string keys' => [
                '~',
                ['test1' => ['test1' => ['test1' => [['test1']]]], 'test2' => ['test2', 'test2a']],
                ['test1~test1~test1~0~0' => 'test1', 'test2~0' => 'test2', 'test2~1' => 'test2a']
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function invalidDelimiterDataProvider() {
        return [
            'Empty String Deliminator' => [''],
            'Null Deliminator' => [null],
            'Array Deliminator' => [[]],
        ];
    }
}
