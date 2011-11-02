<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opAuthConfigFormMobileUID represents a form to configuration.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class opAuthConfigFormMobileUID extends opAuthConfigForm
{
  public function setup()
  {
    parent::setup();

    $this->getWidgetSchema()->setHelp('allow_fallback_uid', 'この設定を有効にすると、ユーザエージェントに埋め込まれた携帯電話個体識別番号の取得がおこなわれるようになります。ユーザエージェント内の携帯電話個体識別番号は信頼できる値ではないため、通常、この設定を有効にするべきではありません。なお、アップグレード時のデフォルト設定は「取得しない」となっています。');
  }
}
