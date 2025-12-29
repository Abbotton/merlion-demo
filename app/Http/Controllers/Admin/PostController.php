<?php

namespace App\Http\Controllers\Admin;

use App\Form\Fields\Radio;
use App\Models\Post;
use Merlion\Http\Controllers\CrudController;

class PostController extends CrudController
{
    protected string $model = Post::class;

    protected string $label = '文章';

    protected function schemas(): array
    {
        if (request()->routeIs('admin.posts.show')) {
            return [
                \Merlion\Components\Show\Grid\Text::make('title')->label('标题')->copyable(),
                \Merlion\Components\Show\Grid\Text::make('status')
                    ->label('状态')
                    ->displayValueUsing(fn () => $this->formatStatus($this->current_model->status)),
                \Merlion\Components\Show\Grid\Text::make('created_at')->label('创建时间'),
                \Merlion\Components\Show\Grid\Text::make('updated_at')->label('更新时间'),
                \Merlion\Components\Show\Grid\Text::make('body')->label('正文'),
            ];
        }

        return [
            \Merlion\Components\Form\Fields\Text::make('title')
                ->label('标题')
                ->rules('required|unique:posts,title,'.request()->route('post'))
                ->required(),
            Radio::make('status')->label('状态')->options(['未上架', '已上架']),
            \Merlion\Components\Form\Fields\Textarea::make('body')
                ->email()
                ->label('正文')
                ->rules('required|string')
                ->required(),
        ];
    }

    private function formatStatus(bool $status)
    {
        return $status
            ? '<span class="badge bg-green text-green-fg">已上架</span>'
            : '<span class="badge bg-red text-red-fg">已下架</span>';
    }

    protected function searches(): array
    {
        return ['title'];
    }

    protected function columns(): array
    {
        return [
            \Merlion\Components\Table\Columns\Text::make('id')->label('ID')->sortable(),
            \Merlion\Components\Table\Columns\Text::make('title')->label('标题')->copyable(),
            \Merlion\Components\Table\Columns\Text::make('status')
                ->label('状态')
                ->displayValueUsing(fn ($text) => $this->formatStatus($text->getModel()->status)),
            \Merlion\Components\Table\Columns\Text::make('created_at')->label('创建时间')->sortable(),
            \Merlion\Components\Table\Columns\Text::make('updated_at')->label('修改时间')->sortable(),
        ];
    }
}
