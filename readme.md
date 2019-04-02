# Form

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require plum/form
```

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

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

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
[link-author]: https://github.com/plum
[link-contributors]: ../../contributors
