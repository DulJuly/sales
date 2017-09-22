<?php
/**
 * Created by PhpStorm.
 * User: leevare
 * Date: 2017/9/22
 * Time: 10:55
 */

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator {

    protected $errors;

    public function validate($req, $rules) {

        foreach ($rules as $champ => $rule) {
            try {
                $rule->setName(ucfirst($champ))->assert($req->getParam($champ));
            } catch (NestedValidationException $e) {
                $this->errors[$champ] = $e->getFullMessage();
            }
        }

        $_SESSION['errors'] = $this->errors;
        return $this;
    }

    public function failed() {
        return !empty($this->errors);
    }
}