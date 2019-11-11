Forms
=====

Reusable form controls.

BaseFormControl
---------------

Simple form component skeleton. Component form should be created in ```createComponentForm``` method, form template is expected to be saved in *./\<className\>.tpl* 

```php
class MyForm extends \AipNg\Forms\BaseFormControl
{

  public function createComponentForm()
  {
    $form = ...
    
    return $form;
  }

}

//  in presenter

class MyPresenter
  public function createComponentMyForm()
  {
    return new MyForm;
  }

  public function actionEdit()
  {
    $this['myForm']->setDefaults([
      ...
    ]);
  }
```

Latte
-----

Input description macro helps to show control's description in template when using manual render.

Register in config.neon:

```php
latte:
    macros:
        - AipNg\Latte\Macro\InputDescriptionMacro::register
```

Just use anywhere in template

```php
{inputDescription $controlName}
```
