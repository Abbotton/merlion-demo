<?php
declare(strict_types=1);

namespace App\Form\Fields;

use Merlion\Components\Concerns\AsInput;
use Merlion\Components\Form\Fields\Field;

class ColorCheckbox extends Field
{
    use AsInput;

    public array $colors = [
        'dark',
        'white',
        'blue',
        'azure',
        'indigo',
        'purple',
        'pink',
        'red',
        'orange',
        'yellow',
        'lime',
        'green'
    ];

    public array $checkedColors = [];

    public array $lightColors = ['white'];

    protected mixed $view = 'form.fields.color-checkbox';

    /**
     * 设置可用颜色列表
     */
    public function colors(array $colors): static
    {
        $this->colors = $colors;
        return $this;
    }

    /**
     * 设置默认选中的颜色
     */
    public function checked(array $colors): static
    {
        $this->checkedColors = $colors;
        return $this;
    }

    /**
     * 设置需要使用浅色样式的颜色
     */
    public function lightColors(array $colors): static
    {
        $this->lightColors = $colors;
        return $this;
    }

    /**
     * 判断颜色是否需要使用浅色样式
     */
    public function isLightColor(string $color): bool
    {
        return in_array($color, $this->lightColors);
    }

    /**
     * 判断颜色是否被选中
     */
    public function isChecked(string $color): bool
    {
        // 优先检查表单提交的值
        $value = $this->getValue();
        if (is_array($value)) {
            return in_array($color, $value);
        }

        // 检查默认选中值
        return in_array($color, $this->checkedColors);
    }
}
