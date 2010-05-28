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
      'guid'       => new sfValidatorString(array('required' => false)),
      'mobile_uid' => new sfValidatorString(array('required' => false)),
      'mobile_cookie_uid' => new sfValidatorString(array('required' => false)),
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
    $validator = new opAuthValidatorMemberConfig(array('config_name' => 'mobile_cookie_uid'));
    $values = $validator->clean($values);
    if (isset($values['member']))
    {
      return $values;
    }

    $validator = new opAuthValidatorMemberConfig(array('config_name' => 'mobile_uid'));
    $values = $validator->clean($values);
    if (isset($values['member']) && $values['member']->getConfig('mobile_cookie_uid'))
    {
      // The specified member already use mobile_cookie_uid, but this request doesn't contain the cookie.
      // This request must not be allowed.
      unset($values['member']);
    }

    return $values;
  }
}
