Goto public assets



git clone https://github.com/mohamed7sameer/tinymce

Goto Nova Service Provider

```php
public function boot(): void
    {
        parent::boot();

        //
        Nova::remoteScript(asset('assets/tinymce/tinymce.min.js'));

    }
```