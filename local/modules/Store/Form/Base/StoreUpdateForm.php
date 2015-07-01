<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace Store\Form\Base;

use Store\Form\StoreCreateForm as ChildStoreCreateForm;
use Store\Form\Type\StoreIdType;

/**
 * Class StoreForm
 * @package Store\Form
 * @author TheliaStudio
 */
class StoreUpdateForm extends ChildStoreCreateForm
{
    const FORM_NAME = "store_update";

    public function buildForm()
    {
        parent::buildForm();

        $this->formBuilder
            ->add("id", StoreIdType::TYPE_NAME)
            ->remove("visible")
        ;
    }
}