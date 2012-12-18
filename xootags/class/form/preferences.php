<?php
/**
 * Xootags module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         Xootags
 * @since           2.6.0
 * @author          Laurent JEN (Aka DuGris)
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class XooTagsPreferencesForm extends XoopsThemeForm
{
    private $_config = array();

    private $_colors = array(
        'Aqua'    => '#00FFFF',
        'Black'   => '#000000',
        'Blue'    => '#0000FF',
        'Fuchsia' => '#FF00FF',
        'Gray'    => '#808080',
        'Green'   => '#008000',
        'Lime'    => '#00FF00',
        'Maroon'  => '#800000',
        'Navy'    => '#000080',
        'Olive'   => '#808000',
        'Purple'  => '#800080',
        'Red'     => '#FF0000',
        'Silver'  => '#C0C0C0',
        'Teal'    => '#008080',
        'White'   => '#FFFFFF',
        'Yellow'  => '#FFFF00',
    );

    /**
     * @param null $obj
     */
    public function __construct()
    {        $this->_config = XooTagsPreferences::getInstance()->loadConfig();

        $xoops = Xoops::getinstance();        extract( $this->_config );
        parent::__construct('', 'form_preferences', 'preferences.php', 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        $tabtray = new XoopsFormTabTray('', 'uniqueid');

        /**
         * Main page
         */
        $tab1 = new XoopsFormTab(_XOO_CONFIG_MAINPAGE, 'tabid-1');
        //welcome
        $tab1->addElement( new XoopsFormTextArea(_XOO_CONFIG_WELCOME, 'xootags_welcome', $xootags_welcome, 12, 12) );

        // Display mode
        $category_mode = new XoopsFormSelect(_XOO_CONFIG_DISPLAY_MODE, 'xootags_main_mode', $xootags_main_mode);
        $category_mode->addOption('blog',   _XOO_CONFIG_MODE_BLOG);
        $category_mode->addOption('cloud',  _XOO_CONFIG_MODE_CLOUD);
        $tab1->addElement( $category_mode );

        // Display count
        $tab1->addElement( new XoopsFormRadioYN(_XOO_CONFIG_COUNT, 'xootags_count', $xootags_count) );

        // limit per page
        $tab1->addElement( new XoopsFormText(_XOO_CONFIG_LIMIT_MAIN, 'xootags_limit_tag_main', 1, 10, $xootags_limit_tag_main) );

        $tabtray->addElement($tab1);

        /**
         * Tags
         */
        $tab2 = new XoopsFormTab(_XOO_CONFIG_TAGS, 'tabid-2');
        // font size
        $tab2->addElement( new XoopsFormText(_XOO_CONFIG_FONT_MAX, 'xootags_font_max', 1, 10, $xootags_font_max) );
        $tab2->addElement( new XoopsFormText(_XOO_CONFIG_FONT_MIN, 'xootags_font_min', 1, 10, $xootags_font_min) );

        $colors_tray = new XoopsFormElementTray(_XOO_CONFIG_COLORS, '' );
        $colors_select = new XoopsFormSelect('', 'xootags_colors', $xootags_colors, 5, true);
        $extra = '';
        foreach ( $this->_colors as $k => $color ) {            $colors_select->addOption( $k );
            $extra .= '<div class="color-div"><div class="color-box" style="background-color:' . $color . ';"></div>' . $k . '</div>';
        }

        $colors_tray->addElement( $colors_select );
        $colors_tray->addElement( new XoopsFormLabel( '', '<div class="colors">' . $extra . '</div>' ) );
        $tab2->addElement( $colors_tray );

        $tabtray->addElement($tab2);

        /**
         * Qrcode
         */
        if ( $xoops->isActiveModule('qrcode') ) {
            $qrcode = new XoopsFormTab(_XOO_CONFIG_QRCODE, 'tabid-qrcode');
            $xoops->theme()->addScript('modules/xootags/include/qrcode.js');

            // use QR code
            $qrcode->addElement( new XoopsFormRadioYN(_XOO_CONFIG_QRCODE_USE, 'xootags_qrcode[use_qrcode]', $xootags_qrcode['use_qrcode']) );

            // Error Correction Level
            $ecl_mode = new XoopsFormSelect(_XOO_CONFIG_QRCODE_ECL, 'xootags_qrcode[CorrectionLevel]', $xootags_qrcode['CorrectionLevel']);
            $ecl_mode->setExtra( "onchange='showImgQRcode(\"image_qrcode\", \"" . 'xootags' . "\", \"url=http://dugris.xoofoo.org\", \"" . $xoops->url('modules') . "\")'" );
            $ecl_mode->addOption(0,   _XOO_CONFIG_QRCODE_ECL_L);
            $ecl_mode->addOption(1,   _XOO_CONFIG_QRCODE_ECL_M);
            $ecl_mode->addOption(2,   _XOO_CONFIG_QRCODE_ECL_Q);
            $ecl_mode->addOption(3,   _XOO_CONFIG_QRCODE_ECL_H);
            $qrcode->addElement( $ecl_mode );

            // Matrix Point Size
            $matrix_mode = new XoopsFormSelect(_XOO_CONFIG_QRCODE_MATRIX, 'xootags_qrcode[matrixPointSize]', $xootags_qrcode['matrixPointSize']);
            $matrix_mode->setExtra( "onchange='showImgQRcode(\"image_qrcode\", \"" . 'xootags' . "\", \"url=http://dugris.xoofoo.org\", \"" . $xoops->url('modules') . "\")'" );
            for ($i = 1; $i <= 5; $i++) {
                $matrix_mode->addOption($i, $i);
            }
            $qrcode->addElement( $matrix_mode );

            // Margin
            $margin_mode = new XoopsFormSelect(_XOO_CONFIG_QRCODE_MARGIN, 'xootags_qrcode[whiteMargin]', $xootags_qrcode['whiteMargin']);
            $margin_mode->setExtra( "onchange='showImgQRcode(\"image_qrcode\", \"" . 'xootags' . "\", \"url=http://dugris.xoofoo.org\", \"" . $xoops->url('modules') . "\")'" );
            for ($i = 0; $i <= 20; $i++) {
                $margin_mode->addOption($i,   $i);
            }
            $qrcode->addElement( $margin_mode );

            // Background & Foreground Color
            $colors_tray = new XoopsFormElementTray(_XOO_CONFIG_QRCODE_COLORS, '' );

            $colors_bg = new XoopsFormSelect(_XOO_CONFIG_QRCODE_COLORS_BG . ': ', 'xootags_qrcode[backgroundColor]', $xootags_qrcode['backgroundColor'], 1);
            $colors_bg->setExtra( "onchange='showImgQRcode(\"image_qrcode\", \"" . 'xootags' . "\", \"url=http://dugris.xoofoo.org\", \"" . $xoops->url('modules') . "\")'" );

            $colors_fg = new XoopsFormSelect(_XOO_CONFIG_QRCODE_COLORS_FG . ': ', 'xootags_qrcode[foregroundColor]', $xootags_qrcode['foregroundColor'], 1);
            $colors_fg->setExtra( "onchange='showImgQRcode(\"image_qrcode\", \"" . 'xootags' . "\", \"url=http://dugris.xoofoo.org\", \"" . $xoops->url('modules') . "\")'" );

            foreach ( $this->_colors as $k => $color ) {
                $colors_bg->addOption( $k );
                $colors_fg->addOption( $k );
            }
            $colors_tray->addElement( new XoopsFormLabel( '', "<div class='floatright'><img src='" . $xoops->url('/modules/xootags/') . "qrcode.php?url=http://dugris.xoofoo.org' name='image_qrcode' id='image_qrcode' alt='" . _XOO_CONFIG_QRCODE . "' /></div>" ) );
            $colors_tray->addElement( $colors_bg );
            $colors_tray->addElement( new XoopsFormLabel( '', '<br />') );
            $colors_tray->addElement( $colors_fg );

            $qrcode->addElement( $colors_tray );

            $tabtray->addElement( $qrcode );
        } else {            $this->addElement( new XoopsFormHidden('xootags_qrcode[use_qrcode]', 0) );
        }

        $this->addElement($tabtray);

        /**
         * Buttons
         */
        $button_tray = new XoopsFormElementTray('', '');
        $button_tray->addElement(new XoopsFormHidden('op', 'save'));

        $button = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
        $button->setClass('btn btn-success');
        $button_tray->addElement($button);

        $button_2 = new XoopsFormButton('', 'reset', _RESET, 'reset');
        $button_2->setClass('btn btn-warning');
        $button_tray->addElement($button_2);

        $button_3 = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
        $button_3->setExtra("onclick='javascript:history.go(-1);'");
        $button_3->setClass('btn btn-danger');
        $button_tray->addElement($button_3);

        $this->addElement($button_tray);
    }
}
?>