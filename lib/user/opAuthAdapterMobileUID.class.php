<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opAuthAdapterMobileUID will handle credential for MobileUID.
 *
 * @package    OpenPNE
 * @subpackage user
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class opAuthAdapterMobileUID extends opAuthAdapter
{
  protected $authModuleName = 'mobileUID';

  public function getAuthParameters()
  {
    $params = parent::getAuthParameters();
    $params['mobile_uid'] = $this->getRequest()->getMobileUID();
    $params['mobile_cookie_uid'] = $this->getRequest()->getMobileUidCookie();
    return $params;
  }

  /**
   * Returns true if the current state is a beginning of register.
   *
   * @return bool returns true if the current state is a beginning of register, false otherwise
   */
  public function isRegisterBegin($member_id = null)
  {
    return false;
  }

  /**
   * Returns true if the current state is a end of register.
   *
   * @return bool returns true if the current state is a end of register, false otherwise
   */
  public function isRegisterFinish($member_id = null)
  {
    return false;
  }

  /**
   * Registers data to storage container.
   *
   * @param  int    $memberId
   * @param  sfForm $form
   * @return bool   true if the data has already been saved, false otherwise
   */
  public function registerData($memberId, $form)
  {
    return false;
  }
}
