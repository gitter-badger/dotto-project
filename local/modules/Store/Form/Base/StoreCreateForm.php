<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace Store\Form\Base;

use Store\Store;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class StoreCreateForm
 * @package Store\Form\Base
 * @author TheliaStudio
 */
class StoreCreateForm extends BaseForm
{
    const FORM_NAME = "store_create";

    public function buildForm()
    {
        $translationKeys = $this->getTranslationKeys();
        $fieldsIdKeys = $this->getFieldsIdKeys();

        $this->addVisibleField($translationKeys, $fieldsIdKeys);
        $this->addTitleField($translationKeys, $fieldsIdKeys);
        $this->addDescriptionField($translationKeys, $fieldsIdKeys);
        $this->addAdminIdField($translationKeys, $fieldsIdKeys);
        $this->addCompanyField($translationKeys, $fieldsIdKeys);
        $this->addFirstnameField($translationKeys, $fieldsIdKeys);
        $this->addLastnameField($translationKeys, $fieldsIdKeys);
        $this->addAddress1Field($translationKeys, $fieldsIdKeys);
        $this->addAddress2Field($translationKeys, $fieldsIdKeys);
        $this->addAddress3Field($translationKeys, $fieldsIdKeys);
        $this->addZipcodeField($translationKeys, $fieldsIdKeys);
        $this->addCityField($translationKeys, $fieldsIdKeys);
        $this->addPhoneField($translationKeys, $fieldsIdKeys);
        $this->addCellphoneField($translationKeys, $fieldsIdKeys);
        $this->addVatNumberField($translationKeys, $fieldsIdKeys);
        $this->addLatField($translationKeys, $fieldsIdKeys);
        $this->addLngField($translationKeys, $fieldsIdKeys);
        $this->addLocaleField();
    }

    public function addLocaleField()
    {
        $this->formBuilder->add(
            'locale',
            'hidden',
            [
                'constraints' => [ new NotBlank() ],
                'required'    => true,
            ]
        );
    }

    protected function addVisibleField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("visible", "checkbox", array(
            "label" => $this->translator->trans($this->readKey("visible", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("visible", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addTitleField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("title", "text", array(
            "label" => $this->translator->trans($this->readKey("title", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("title", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addDescriptionField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("description", "textarea", array(
            "label" => $this->translator->trans($this->readKey("description", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("description", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addAdminIdField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("admin_id", "integer", array(
            "label" => $this->translator->trans($this->readKey("admin_id", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("admin_id", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addCompanyField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("company", "text", array(
            "label" => $this->translator->trans($this->readKey("company", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("company", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addFirstnameField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("firstname", "text", array(
            "label" => $this->translator->trans($this->readKey("firstname", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("firstname", $fieldsIdKeys)],
            "required" => true,
            "constraints" => array(
                new NotBlank(),
            ),
            "attr" => array(
            )
        ));
    }

    protected function addLastnameField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("lastname", "text", array(
            "label" => $this->translator->trans($this->readKey("lastname", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("lastname", $fieldsIdKeys)],
            "required" => true,
            "constraints" => array(
                new NotBlank(),
            ),
            "attr" => array(
            )
        ));
    }

    protected function addAddress1Field(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("address1", "text", array(
            "label" => $this->translator->trans($this->readKey("address1", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("address1", $fieldsIdKeys)],
            "required" => true,
            "constraints" => array(
                new NotBlank(),
            ),
            "attr" => array(
            )
        ));
    }

    protected function addAddress2Field(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("address2", "text", array(
            "label" => $this->translator->trans($this->readKey("address2", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("address2", $fieldsIdKeys)],
            "required" => true,
            "constraints" => array(
                new NotBlank(),
            ),
            "attr" => array(
            )
        ));
    }

    protected function addAddress3Field(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("address3", "text", array(
            "label" => $this->translator->trans($this->readKey("address3", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("address3", $fieldsIdKeys)],
            "required" => true,
            "constraints" => array(
                new NotBlank(),
            ),
            "attr" => array(
            )
        ));
    }

    protected function addZipcodeField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("zipcode", "text", array(
            "label" => $this->translator->trans($this->readKey("zipcode", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("zipcode", $fieldsIdKeys)],
            "required" => true,
            "constraints" => array(
                new NotBlank(),
            ),
            "attr" => array(
            )
        ));
    }

    protected function addCityField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("city", "text", array(
            "label" => $this->translator->trans($this->readKey("city", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("city", $fieldsIdKeys)],
            "required" => true,
            "constraints" => array(
                new NotBlank(),
            ),
            "attr" => array(
            )
        ));
    }

    protected function addPhoneField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("phone", "text", array(
            "label" => $this->translator->trans($this->readKey("phone", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("phone", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addCellphoneField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("cellphone", "text", array(
            "label" => $this->translator->trans($this->readKey("cellphone", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("cellphone", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addVatNumberField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("vat_number", "text", array(
            "label" => $this->translator->trans($this->readKey("vat_number", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("vat_number", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addLatField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("lat", "text", array(
            "label" => $this->translator->trans($this->readKey("lat", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("lat", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addLngField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("lng", "text", array(
            "label" => $this->translator->trans($this->readKey("lng", $translationKeys), [], Store::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("lng", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    public function getName()
    {
        return static::FORM_NAME;
    }

    public function readKey($key, array $keys, $default = '')
    {
        if (isset($keys[$key])) {
            return $keys[$key];
        }

        return $default;
    }

    public function getTranslationKeys()
    {
        return array();
    }

    public function getFieldsIdKeys()
    {
        return array(
            "visible" => "store_visible",
            "position" => "store_position",
            "title" => "store_title",
            "description" => "store_description",
            "admin_id" => "store_admin_id",
            "company" => "store_company",
            "firstname" => "store_firstname",
            "lastname" => "store_lastname",
            "address1" => "store_address1",
            "address2" => "store_address2",
            "address3" => "store_address3",
            "zipcode" => "store_zipcode",
            "city" => "store_city",
            "phone" => "store_phone",
            "cellphone" => "store_cellphone",
            "vat_number" => "store_vat_number",
            "lat" => "store_lat",
            "lng" => "store_lng",
        );
    }
}