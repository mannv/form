# Form

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

1. Via Composer

``` bash
$ composer require plum/form
```

2. mở file `layout` thêm stack vào cuối trang để tự động đẩy code validate js vào

```
    @stack('scripts')
```

Tham khảo: [https://laravel.com/docs/5.8/blade#stacks](https://laravel.com/docs/5.8/blade#stacks)

3. cài đặt validateJS

[https://github.com/proengsoft/laravel-jsvalidation/wiki/Laravel-5.6-installation](https://github.com/proengsoft/laravel-jsvalidation/wiki/Laravel-5.6-installation)

## Usage
in blade template

```
{!! Pform::open(['url' => route('bt.store'), 'id' => 'form-demo'], \App\Http\Requests\DemoRequest::class) !!}
    {!! Pform::text('name', __('Your name')) !!}
    {!! Pform::email('email', __('Your email')) !!}
    {!! Pform::tel('phone_number', __('Your phone')) !!}
    {!! Pform::url('url', __('Your Site')) !!}
    {!! Pform::number('point', __('Point')) !!}
    {!! Pform::textarea('description', __('Description')) !!}
    {!! Pform::submit(__('Submit')) !!}
{!! Pform::close() !!}
```

Output: 

![Output](https://raw.githubusercontent.com/mannv/form/6a0782fadb435a7d985e62791b13f85ca5b9178d/output.png)


### Other demo

```
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">
            @if(Route::currentRouteName() == 'backend.admin.create')
                {{__('Create new admin')}}
            @else
                {{__('Edit admin')}}
            @endif
        </h3>
    </div>

    @if(Route::currentRouteName() == 'backend.admin.create')
        {!! Pform::open(['url' => route('backend.admin.store'), 'method' => 'POST'], \Modules\Backend\Http\Requests\AdminRequest::class) !!}
    @else
        {!! Pform::model($data, ['url' => route('backend.admin.update', ['id' => $data['id']]), 'method' => 'PUT'], \Modules\Backend\Http\Requests\AdminRequest::class) !!}
    @endif
        <div class="box-body">
            {!! Pform::text('name', __('Name')) !!}
            {!! Pform::email('email', __('Email')) !!}
            {!! Pform::password('password', __('Password')) !!}
            {!! Pform::password('password_confirmation', __('Reenter Password')) !!}
        </div>
        <div class="box-footer">
            {!! Pform::submit(__('Submit'), ['class' => 'btn btn-success']) !!}
        </div>
    {!! Pform::close() !!}
</div>
```


## Publish Configuration

```
php artisan vendor:publish --provider "Plum\Form\FormServiceProvider"
```

## Form option


|Option|Type|Default|Description|
|--|--|--|--|
|id|string|random|duy nhất trên trang HTML, cho phần validate form với javascript, nếu không muốn validate bằng js có thể đưa id này vào cấu hình **skip_validate_js** trong file cấu hình `pform.php`|
|view|string|form_group|tên view sẽ dùng để render lên các phần tử, view này sẽ nằm trong namespace `plum`|
|hide_mandatory|boolean|false| **true** sẽ không hiển thị dấu **\*** đỏ bên cạnh label|




## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email anhmantk@gmail.com instead of using the issue tracker.

## Credits

- [mannv][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/plum/form.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/plum/form.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/plum/form/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/plum/form
[link-downloads]: https://packagist.org/packages/plum/form
[link-travis]: https://travis-ci.org/plum/form
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/mannv
[link-contributors]: ../../contributors
