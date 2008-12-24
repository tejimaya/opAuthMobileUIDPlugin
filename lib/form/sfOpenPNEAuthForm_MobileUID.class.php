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

    $this->mergePostValidator(new sfValidatorCallback(array(
      'callback'  => array($this, 'validateId'),
    )));

    parent::configure();
  }

  public function validateId($validator, $value, $arguments = array())
  {
    $mobileUID = sfContext::getInstance()->getRequest()->getMobileUID();
    $data = MemberConfigPeer::retrieveByNameAndValue('mobile_uid', $mobileUID);
    if (!$data)
    {
      throw new sfValidatorError($validator, 'Not a valid UID.');
    }

    $value['member_id'] = $data->getMember()->getId();
    return $value;
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
