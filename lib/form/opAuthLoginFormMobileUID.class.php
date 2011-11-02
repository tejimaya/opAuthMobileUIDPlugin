<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opAuthLoginFormMobileUID represents a form to login by one's mobile UID.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class opAuthLoginFormMobileUID extends opAuthLoginForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'guid' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidatorSchema(new sfValidatorSchema(array(
      'guid' => new sfValidatorString(array('required' => false)),
      'mobile_uid' => new sfValidatorString(array('required' => false)),
      'mobile_uid_fallback' => new sfValidatorString(array('required' => false)),
    )));

    $this->setDefault('guid', 'on');

    $this->mergePostValidator(new sfValidatorCallback(array('callback' => array($this, 'validateMobileUid'))));

    parent::configure();
  }

  public function isUtn()
  {
    return true;
  }

  public function validateMobileUid($validator, $values, $arguments = array())
  {
    $keys = array('mobile_uid', 'mobile_uid_fallback');

    foreach ($keys as $key)
    {
      $validator = new opAuthValidatorMemberConfig(array(
        'config_name'       => 'mobile_uid',
        'allow_empty_value' => false,
        'field_name'        => $key,
      ));
      $values = $validator->clean($values);

      if (!empty($values['member']))
      {
        break;
      }
    }

    return $values;
  }
}
