<?php

declare(strict_types=1);

namespace App\Form\Fields;

use Merlion\Components\Concerns\AsInput;
use Merlion\Components\Form\Fields\Field;

class Radio extends Field
{
    use AsInput;

    public array $options = [];

    public ?string $checkedValue = null;

    public array $disabledValues = [];

    protected mixed $view = 'form.fields.radio';

    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function checked(string $value): static
    {
        $this->checkedValue = $value;

        return $this;
    }

    public function disabled(array $values): static
    {
        $this->disabledValues = $values;

        return $this;
    }

    public function isDisabled(string $value): bool
    {
        return in_array($value, $this->disabledValues, true);
    }

    public function isChecked(string $value): bool
    {
        return $this->getValue() == $value || $this->checkedValue == $value;
    }
}
