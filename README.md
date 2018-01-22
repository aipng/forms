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

ObjectCheckboxList
------------------

Maps given objects to CheckboxList control. Example:

```php
$control = new ObjectCheckboxList(
  'control label',
  $myObjectList,
  function (MyObject $listItem) {
    return [
      $listItem->getId() => $listItem->getName(),
    ];
  });
```


ObjectSelectBox
------------------

Maps given objects to SelectBox control. Example:

```php
$control = new ObjectSelectBox(
  'control label',
  $myObjectList,
  function (MyObject $item) {
    return [
      $item->getId() => $item->getName(),
    ];
  });
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
