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
      'mobile_uid' => new sfValidatorString(array('required' => true)),
    )));

    $this->setDefault('guid', 'on');

    $this->mergePostValidator(
      new opAuthValidatorMemberConfig(array('config_name' => 'mobile_uid'))
    );

    parent::configure();
  }

  public function isUtn()
  {
    return true;
  }
}
