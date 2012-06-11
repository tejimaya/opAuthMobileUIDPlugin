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
  const MUST_USE_COOKIE_UID = 2;
  const COOKIE_UID_AND_MOBILE_UID = 1;
  const MUST_USE_MOBILE_UID = 0;

  public function configure()
  {
    $this->setWidgets(array(
      'guid' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidatorSchema(new sfValidatorSchema(array(
      'guid' => new sfValidatorString(array('required' => false)),
      'mobile_uid' => new sfValidatorString(array('required' => false)),
      'mobile_uid_fallback_op3' => new sfValidatorString(array('required' => false)),
      'mobile_uid_fallback_op2' => new sfValidatorString(array('required' => false)),
      'mobile_cookie_uid' => new sfValidatorString(array('required' => false)),
    )));

    $this->setDefault('guid', 'on');

    $this->mergePostValidator(new sfValidatorCallback(array('callback' => array($this, 'validateMobileUid'))));

    parent::configure();
  }

  public function isUtn()
  {
    $uidType = $this->adapter->getAuthConfig('uid_type');

    return (
      self::MUST_USE_MOBILE_UID == $uidType ||
      (self::COOKIE_UID_AND_MOBILE_UID == $uidType && !sfContext::getInstance()->getRequest()->isCookie())
    );
  }

  public function validateMobileUid($validator, $values, $arguments = array())
  {
    $uidType = $this->adapter->getAuthConfig('uid_type');

    $isUseMobileCookie = sfConfig::get('op_is_use_mobile_cookie', true);
    if (self::MUST_USE_MOBILE_UID != $uidType && $isUseMobileCookie)
    {
      $values = $this->validateUsingMobileCookieUid($values);
      if (isset($values['member']))
      {
        return $values;
      }
    }

    if (self::MUST_USE_COOKIE_UID != $uidType)
    {
      $values = $this->validateUsingMobileUid($values);

      $hasMobileCookieUid = isset($values['member']) && $values['member']->getConfig('mobile_cookie_uid');
      if ($hasMobileCookieUid && $isUseMoileCookie)
      {
        // The specified member already use mobile_cookie_uid, but this request doesn't contain the cookie.
        // This request must not be allowed.
        unset($values['member']);
      }
    }

    return $values;
  }

  private function validateUsingMobileCookieUid($values)
  {
    $validator = new opAuthValidatorMemberConfig(array(
      'config_name'       => 'mobile_cookie_uid',
      'allow_empty_value' => false,
    ));
    $values = $validator->clean($values);

    return $values;
  }

  private function  validateUsingMobileUid($values)
  {
    $keys = array('mobile_uid', 'mobile_uid_fallback_op3', 'mobile_uid_fallback_op2');

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
