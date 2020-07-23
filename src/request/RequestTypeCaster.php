<?php

namespace vjik\yii2\typeCaster\request;

use vjik\typeCaster\TypeCaster;
use yii\web\BadRequestHttpException;

class RequestTypeCaster
{

    /**
     * @var bool
     */
    public $required = false;

    /**
     * @var mixed
     */
    public $default;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var TypeCaster
     */
    protected $caster;

    /**
     * @param string $name
     * @param mixed $value
     * @param TypeCaster $caster
     */
    public function __construct($name, $value, TypeCaster $caster)
    {
        $this->name = $name;
        $this->value = $value;
        $this->caster = $caster;
    }

    /**
     * @return self
     */
    public function required(): self
    {
        $this->required = true;
        return $this;
    }

    /**
     * @return self
     */
    public function optional(): self
    {
        $this->required = false;
        return $this;
    }

    /**
     * @param mixed $value
     * @return self
     */
    public function default($value): self
    {
        $this->default = $value;
        return $this;
    }

    /**
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function getValue()
    {
        return $this->prepareValue();
    }

    /**
     * @return bool
     * @throws BadRequestHttpException
     */
    public function getBool(): bool
    {
        return $this->caster->toBool($this->prepareValue());
    }

    /**
     * @return int
     * @throws BadRequestHttpException
     */
    public function getInt(): int
    {
        return $this->caster->toInt($this->prepareValue());
    }

    /**
     * @return float
     * @throws BadRequestHttpException
     */
    public function getFloat(): float
    {
        return $this->caster->toFloat($this->prepareValue());
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function getString(): string
    {
        return $this->caster->toString($this->prepareValue());
    }

    /**
     * @return bool|null
     * @throws BadRequestHttpException
     */
    public function getBoolOrNull(): ?bool
    {
        return $this->caster->toBoolOrNull($this->prepareValue());
    }

    /**
     * @return int|null
     * @throws BadRequestHttpException
     */
    public function getIntOrNull(): ?int
    {
        return $this->caster->toIntOrNull($this->prepareValue());
    }

    /**
     * @return float|null
     * @throws BadRequestHttpException
     */
    public function getFloatOrNull(): ?float
    {
        return $this->caster->toFloatOrNull($this->prepareValue());
    }

    /**
     * @return string|null
     * @throws BadRequestHttpException
     */
    public function getStringOrNull(): ?string
    {
        return $this->caster->toStringOrNull($this->prepareValue());
    }

    /**
     * @return mixed
     * @throws BadRequestHttpException
     */
    protected function prepareValue()
    {
        if ($this->required && $this->value === null) {
            throw new BadRequestHttpException('Missing required ' . $this->name);
        }
        return $this->value === null ? $this->default : $this->value;
    }
}
