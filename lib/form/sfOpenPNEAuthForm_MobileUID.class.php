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
      'guid' => new sfValidatorString(array('required' => false)),
    )));

    $this->setDefault('guid', 'on');

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
