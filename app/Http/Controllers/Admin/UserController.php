<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Merlion\Components\Concerns\Admin\HasToast;
use Merlion\Http\Controllers\CrudController;

class UserController extends CrudController
{
    use HasToast;

    protected string $model = User::class;

    protected string $label = '用户';

    public function afterIndexLoaded(...$args)
    {
        $this->success('Page loaded');
    }

    protected function schemas(): array
    {
        if (request()->routeIs('admin.users.show')) {
            return [
                \Merlion\Components\Show\Grid\Text::make('name')->label('名字')->copyable(),
                \Merlion\Components\Show\Grid\Text::make('email')->label('邮箱')->copyable()
            ];
        }

        return [
            \Merlion\Components\Form\Fields\Text::make('name')
                ->label('名字')
                ->rules('required')
                ->required(),
            \Merlion\Components\Form\Fields\Text::make('email')
                ->email()
                ->label('邮箱')
                ->rules('required|email|unique:users,email,' . request()->route('user'))
                ->required(),
            \Merlion\Components\Form\Fields\Text::make('password')
                ->label('密码')
                ->rules(function () {
                    return request()->route('user')
                        ? ['nullable', Password::defaults()]
                        : ['required', Password::defaults()];
                })
                ->password()
                ->required(!request()->route('user'))
        ];
    }

    protected function searches(): array
    {
        return ['name', 'email'];
    }

    protected function columns(): array
    {
        return [
            \Merlion\Components\Table\Columns\Text::make('id')->label('ID')->sortable(),
            \Merlion\Components\Table\Columns\Text::make('name')->label('名字')->copyable(),
            \Merlion\Components\Table\Columns\Text::make('email')->label('邮箱')->copyable(),
        ];
    }
}
