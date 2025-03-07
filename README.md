BaseFormControl
---------------

"Form as a component" control. Form should be defined in ```createComponentForm``` method.

Simple structure:
```plain
/my-app/src/
    templates/MyForm.latte
    MyForm.php
    MyForm.latte
``` 

**MyForm.latte** - customized form template (when needed)
```latte
{form form}
    manual rendering of form controls
    ...
{/form}
```

**MyForm.php**
```php
final class MyForm extends \AipNg\Forms\BaseFormControl
{

  public function createComponentForm(): \Nette\Application\UI\Form
  {
    $form = ...
    
    return $form;
  }

}
```

**Usage in presenter**
```php
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

Input description macro helps to show control's description in template when using manual rendering.

Register in config.neon:

```php
latte:
    extensions::
        - AipNg\Latte\FormInputDescriptionExtension
```

Just use anywhere in form template

```php
{inputDescription $controlName}
```
