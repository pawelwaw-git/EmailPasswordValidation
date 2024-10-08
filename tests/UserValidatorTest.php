<?php


namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use App\UserValidator;

class UserValidatorTest extends TestCase
{
    #[DataProvider('ValidationPasswordDataProvider')]
    public function testValidatePassword(string $password, bool $expected): void
    {
        // Given
        $validator = new UserValidator();

        // When
        $result = $validator->validatePassword($password);
        // Then

        $this->assertSame($expected,$result);
    }

    #[DataProvider('ValidationEmailDataProvider')]
    public function testValidateEmail(string $email, bool $expected): void
    {
        // Given
        $validator = new UserValidator();

        // When
        $result = $validator->validateEmail($email);
        // Then

        $this->assertSame($expected,$result);
    }

    public static function ValidationPasswordDataProvider(): iterable
    {
        yield 'correct password' => [
            'password' => 'Wl@#12345',
            'expected' => true,
        ];

        yield 'invalid password' => [
            'password' => '48342274',
            'expected' => false,
        ];
    }


    public static function ValidationEmailDataProvider():iterable
    {
        yield 'correct email' => [
            'email' => 'pawel@testemail.com',
            'expected' => true,
        ];

        yield 'email without @' => [
           'email' => 'pawel_test_email.com',
           'expected' => false,
        ];

        yield 'email without letter before @' => [
            'email' => '@testemail.com',
            'expected' => false,
        ];

        yield 'email without domain - dot not found' => [
            'email' => 'test@testemailcom',
            'expected' => false,
        ];

        yield 'email no letter in name of domain' => [
            'email' => 'test@.com',
            'expected' => true,
        ];

        yield 'email other characters - no letter in domain after dot' => [
            'email' => 'test@example.5242@#4',
            'expected' => false,
        ];

        yield 'email other characters - one letter in domain after dot' => [
            'email' => 'test@example.52w42@#4',
            'expected' => false,
        ];

        yield 'email one letter in name of domain' => [
            'email' => 'testr@.com',
            'expected' => true,
        ];

        yield 'correct email - domain start with numbers' => [
            'email' => 'testr@.34242com',
            'expected' => true,
        ];

        yield 'correct email - domain letters are not adjacent' => [
            'email' => 'testr@.3c242m',
            'expected' => true,
        ];
    }
}
