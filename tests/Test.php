<?php 
namespace Tests;

abstract class Test extends \PHPUnit\Framework\TestCase
{
    /**
     * Phương thức được gọi trước mỗi lần kiểm tra.
     */
    function setUp(): void {
    }

    /**
     * Phương thức này được gọi giữa setUp () và test.
     */
    function assertPreConditions(): void {
    }

    /**
     * Phương thức này được gọi giữa setUp () và tearDown().
     */
    function assertPostConditions(): void {
    }

    /**
     * Phương thức này được gọi sau mỗi lần test.
     */
    function tearDown(): void {
    }
}