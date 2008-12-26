<?php

/**
 * sfOpenPNEAuthForm_MobileUID represents a form to login.
 *
 * @package    OpenPNE
 * @subpackage user
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class sfOpenPNEAuthForm_MobileUID extends sfOpenPNEAuthForm
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

  public function getAuthMode()
  {
    return 'MobileUID';
  }

  public function isUtn()
  {
    return true;
  }
}
