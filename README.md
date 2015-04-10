HTML/JSON view
==============

Introduction
------------
For AJAX requests, I always prefer JSON over a raw HTML response. I was looking 
for something that just renderes my Zend Framework 2 view, put it into JSON and
returns it. I couldn't find anything that I liked, so I wrote something. You
can not use the composer to use it, you need to copy & paste, or you can just 
get the idea.

The idea is that the HTML view/template is rendered by Zend's PhpRenderer and
that JSON is generally rendered by Zend's JsonRenderer and that's just fine. So
I combined both.


Installation & usage
--------------------
Extend your Zend Framework 2 module config like this:
```php
return array(
    'view_manager' => array(
        'strategies' => array(
            'htmlJsonStrategy'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'htmlJsonRenderer' => 'Antiphp\View\Renderer\HtmlJsonRendererServiceFactory',
            'htmlJsonStrategy' => 'Antiphp\View\Strategy\HtmlJsonStrategyServiceFactory',
        )
    )
);
```

Edit your controller action like this:
```php
class ExampleController /* .. */
{
    public function indexAction() {
        $viewModel = new HtmlJsonModel();
        $viewModel->exampleVar = 'foobar';
        return $viewModel;
    }
}
```

Now when you do a request the HtmlJsonStrategy class checks if you're using the
HtmlJsonModel AND if it's an AJAX request. If so, it returns your HTML embedded
within JSON.

```json
{ html: '<div><h1>foobar</h1></div>' }
```

You did not win anything with this, until you add more data to your JSON. This
could be Zend Framework's flash messenger messages ("saved successfully") or
the ViewModel variables itself ('exampleVar') for further usage in JS.
