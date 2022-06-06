<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\AppUtil\Http;

use CarlosChininin\AppUtil\Validation\Assert;
use DateTimeImmutable;
use Exception;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use function in_array;

class ParamFetcher
{
    private const DATE_FORMAT = 'd-m-Y';

    // TODO: need to add rest of scalar types
    private const SCALAR_TYPES = [ParamType::STRING, ParamType::INT];

    /**
     * @var array<string, mixed>
     */
    private array $data;

    private bool $testScalarType;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data, bool $testScalarType = true)
    {
        $this->data = $data;
        $this->testScalarType = $testScalarType;
    }

    public static function fromRequestAttributes(Request $request): self
    {
        return new self($request->attributes->all(), false);
    }

    public static function fromRequestBody(Request $request): self
    {
        return new self($request->request->all());
    }

    public static function fromRequestQuery(Request $request): self
    {
        return new self($request->query->all(), false);
    }

    public function getRequiredString(string $key): string
    {
        $this->assertRequired($key);
        $this->assertType($key, ParamType::STRING);

        return (string) $this->data[$key];
    }

    public function getNullableString(string $key): ?string
    {
        if (!isset($this->data[$key]) || '' === $this->data[$key]) {
            return null;
        }
        $this->assertType($key, ParamType::STRING);

        return (string) $this->data[$key];
    }

    public function getRequiredInt(string $key): int
    {
        $this->assertRequired($key);
        $this->assertType($key, ParamType::INT);

        return (int) $this->data[$key];
    }

    public function getNullableInt(string $key): ?int
    {
        if (!isset($this->data[$key]) || '' === $this->data[$key]) {
            return null;
        }
        $this->assertType($key, ParamType::INT);

        return (int) $this->data[$key];
    }

    /**
     * @throws Exception
     */
    public function getRequiredDate(string $key): DateTimeImmutable
    {
        $this->assertRequired($key);
        $this->assertType($key, ParamType::DATE);

        return new DateTimeImmutable($this->data[$key]);
    }

    /**
     * @throws Exception
     */
    public function getNullableDate(string $key): ?DateTimeImmutable
    {
        if (!isset($this->data[$key]) || '' === $this->data[$key]) {
            return null;
        }
        $this->assertType($key, ParamType::DATE);

        return new DateTimeImmutable($this->data[$key]);
    }

    // .....
    // TODO:  Add additional required methods for every scalar type
    // .....

    private function assertRequired(string $key): void
    {
        Assert::keyExists($this->data, $key, sprintf('"%s" not found', $key));
        Assert::notNull($this->data[$key], sprintf('"%s" should be not null', $key));
    }

    private function assertType(string $key, ParamType $type): void
    {
        if (!$this->testScalarType && in_array($type, self::SCALAR_TYPES, true)) {
            return;
        }

        switch ($type) {
            case ParamType::STRING:
                Assert::string($this->data[$key], sprintf('"%s" should be a string. Got %%s', $key));
                break;

            case ParamType::INT:
                Assert::string($this->data[$key], sprintf('"%s" should be an integer. Got %%s', $key));
                break;

            case ParamType::DATE:
                Assert::dateTimeString(
                    $this->data[$key],
                    static::DATE_FORMAT,
                    sprintf('"%s" should be a valid format "%s" date', $key, static::DATE_FORMAT)
                );
                break;
            case ParamType::BOOL:
            case ParamType::FLOAT:
            case ParamType::ARRAY:
            case ParamType::OBJECT:
                throw new RuntimeException('Not implemented');
        }
    }

    public function add(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }
}
