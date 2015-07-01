<?php
/**
 * Created by PhpStorm.
 * User: thelia
 * Date: 01/07/2015
 * Time: 12:08
 */

namespace Store\Form;


use Store\Store;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class StoreGpsUpdateForm extends BaseForm
{

    /**
     *
     * in this function you add all the fields you need for your Form.
     * Form this you have to call add method on $this->formBuilder attribute :
     *
     * $this->formBuilder->add("name", "text")
     *   ->add("email", "email", array(
     *           "attr" => array(
     *               "class" => "field"
     *           ),
     *           "label" => "email",
     *           "constraints" => array(
     *               new \Symfony\Component\Validator\Constraints\NotBlank()
     *           )
     *       )
     *   )
     *   ->add('age', 'integer');
     *
     * @return null
     */
    protected function buildForm()
    {
        $this
            ->formBuilder
            ->add(
                'id',
                'store_id'
            )
            ->add(
                'lat',
                'text',
                [
                    "label" => Translator::getInstance()->trans('Latitude', [], Store::MESSAGE_DOMAIN),
                ]
            )
            ->add(
                'lng',
                'text',
                [
                    "label" => Translator::getInstance()->trans('Longitude', [], Store::MESSAGE_DOMAIN),
                ]
            )
        ;
    }

    public function getName()
    {
        return "store_gps_update";
    }


}