<?php if ( ! defined( 'ABSPATH' ) ) exit;
$aFlorpNinjaFormExportData = array (
  'form_settings' => 
  array (
    'title' => 'Rueda organizer profile',
    'key' => '',
    'created_at' => '2018-04-18 10:50:13',
    'unique_field_error' => 'A form with this value has already been submitted.',
    'drawerDisabled' => '',
    'formContentData' => 
    array (
      0 => 'hr_1499211561322',
      1 => 'nadpis_zakladne_informacie_1523963867718',
      2 => 'first_name',
      3 => 'last_name',
      4 => 'user_email',
      5 => 'webpage',
      6 => 'subscriber_type',
      7 => 'school_city',
      8 => 'user_pass',
      9 => 'passwordconfirm',
      10 => 'hr_1499212471823',
      11 => 'nadpis_dalsie_info_1523963911637',
      12 => 'school_name',
      13 => 'school_webpage',
      14 => 'hr_1499212477071',
      15 => 'nadpis_flashmob_1499213672394',
      16 => 'flashmob_number_of_dancers',
      17 => 'video_link_type',
      18 => 'youtube_link',
      19 => 'facebook_link',
      20 => 'vimeo_link',
      21 => 'embed_code',
      22 => 'flashmob_address',
      23 => 'najdi_1499219575360',
      24 => 'map_wrapper_div_1499222834794',
      25 => 'longitude',
      26 => 'latitude',
      27 => 'antispamova_ochrana_1523974918099',
      28 => 'uloz_1499114572027',
    ),
    'fieldsMarkedRequired' => 'Polia označené <span class="ninja-forms-req-symbol">*</span> sú povinné',
    'currency' => '',
    'logged_in' => '0',
    'not_logged_in_msg' => '',
    'sub_limit_msg' => 'The Form has reached it\'s submission limit.',
    'calculations' => 
    array (
    ),
    'honeypotHoneypotError' => '',
    'validateRequiredField' => 'Toto pole je povinné',
    'formErrorsCorrectErrors' => 'Prosíme, opravte chyby',
    'fieldNumberIncrementBy' => '',
    'fieldNumberNumMaxError' => '',
    'fieldNumberNumMinError' => '',
    'confirmFieldErrorMsg' => 'Tieto polia musia byť rovnaké!',
    'changeEmailErrorMsg' => 'Prosíme, zadajte platnú emailovú adresu!',
    'add_submit' => '1',
    'element_class' => '',
    'wrapper_class' => '',
    'default_label_pos' => 'left',
    'hide_complete' => '0',
    'show_title' => '0',
    'clear_complete' => '0',
    'editActive' => '1',
    'objectType' => 'Form Setting',
  ),
  'field_settings' => 
  array (
    198 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '1',
      'container_class' => 'florp-class florp-registration-field',
      'element_class' => '',
      'drawerDisabled' => '',
      'label' => 'Divider',
      'key' => 'hr_1499211561322',
      'type' => 'hr',
    ),
    199 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '2',
      'default' => '<h5>Základné informácie</h5>',
      'container_class' => 'florp-class florp-subscriber-type-field_any',
      'element_class' => '',
      'drawerDisabled' => '',
      'label' => 'Nadpis: Základné informácie',
      'key' => 'nadpis_zakladne_informacie_1523963867718',
      'type' => 'html',
    ),
    200 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '3',
      'label_pos' => 'default',
      'required' => '1',
      'default' => '{wp:user_first_name}',
      'placeholder' => '',
      'container_class' => 'florp-class florp-left florp-registration-field',
      'element_class' => 'florp_first_name',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'drawerDisabled' => '',
      'manual_key' => '1',
      'custom_name_attribute' => 'fname',
      'label' => 'Meno',
      'key' => 'first_name',
      'type' => 'firstname',
    ),
    201 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '4',
      'label_pos' => 'default',
      'required' => '1',
      'default' => '{wp:user_last_name}',
      'placeholder' => '',
      'container_class' => 'florp-class florp-right florp-registration-field',
      'element_class' => 'florp_last_name',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'drawerDisabled' => '',
      'manual_key' => '1',
      'custom_name_attribute' => 'lname',
      'label' => 'Priezvisko',
      'key' => 'last_name',
      'type' => 'lastname',
    ),
    202 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '5',
      'label_pos' => 'default',
      'required' => '1',
      'default' => '{wp:user_email}',
      'placeholder' => '',
      'container_class' => 'florp-class florp-left florp-registration-field',
      'element_class' => 'florp_user_email',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'drawerDisabled' => '',
      'manual_key' => '1',
      'custom_name_attribute' => 'email',
      'label' => 'Emailová adresa',
      'key' => 'user_email',
      'type' => 'email',
    ),
    203 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '6',
      'label_pos' => 'default',
      'required' => '0',
      'default' => '{usermeta:webpage}',
      'placeholder' => 'http://example.com',
      'container_class' => 'florp-class florp-right florp-registration-field',
      'element_class' => 'florp_webpage',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'disable_browser_autocomplete' => '',
      'mask' => '',
      'custom_mask' => '',
      'drawerDisabled' => '',
      'custom_name_attribute' => '',
      'label' => 'Webstránka / FB link profilu, stránky',
      'key' => 'webpage',
      'type' => 'textbox',
    ),
    204 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '8',
      'label_pos' => 'left',
      'required' => '',
      'options' => 
      array (
        0 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Organizátor rueda flashmobu',
          'value' => 'flashmob_organizer',
          'calc' => '',
          'selected' => 0,
          'order' => 0,
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'manual_value' => true,
        ),
        1 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Organizátor tanečných kurzov',
          'value' => 'teacher',
          'calc' => '',
          'selected' => 0,
          'order' => 1,
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'manual_value' => true,
        ),
      ),
      'container_class' => 'florp-class florp-left florp-registration-field florp_subscriber_type_container',
      'element_class' => 'florp_subscriber_type',
      'admin_label' => '',
      'help_text' => '',
      'manual_key' => '1',
      'drawerDisabled' => '',
      'label' => 'Som:',
      'key' => 'subscriber_type',
      'type' => 'listcheckbox',
    ),
    205 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '9',
      'label_pos' => 'default',
      'required' => '',
      'options' => 
      array (
        0 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'order' => 0,
          'new' => false,
          'options' => 
          array (
          ),
          'label' => 'vyberte mesto flashmobu',
          'value' => 'null',
          'calc' => '',
          'selected' => 0,
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'manual_value' => true,
        ),
        1 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Bánovce nad Bebravou',
          'value' => 'Bánovce nad Bebravou',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 1,
        ),
        2 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Banská Bystrica',
          'value' => 'Banská Bystrica',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 2,
        ),
        3 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Banská Štiavnica',
          'value' => 'Banská Štiavnica',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 3,
        ),
        4 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Bardejov',
          'value' => 'Bardejov',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 4,
        ),
        5 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Bojnice',
          'value' => 'Bojnice',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 5,
        ),
        6 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Bratislava',
          'value' => 'Bratislava',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 6,
        ),
        7 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Brezno',
          'value' => 'Brezno',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 7,
        ),
        8 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Brezová pod Bradlom',
          'value' => 'Brezová pod Bradlom',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 8,
        ),
        9 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Bytča',
          'value' => 'Bytča',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 9,
        ),
        10 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Čadca',
          'value' => 'Čadca',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 10,
        ),
        11 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Čierna nad Tisou',
          'value' => 'Čierna nad Tisou',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 11,
        ),
        12 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Detva',
          'value' => 'Detva',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 12,
        ),
        13 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Dobšiná',
          'value' => 'Dobšiná',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 13,
        ),
        14 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Dolný Kubín',
          'value' => 'Dolný Kubín',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 14,
        ),
        15 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Dubnica nad Váhom',
          'value' => 'Dubnica nad Váhom',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 15,
        ),
        16 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Dudince',
          'value' => 'Dudince',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 16,
        ),
        17 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Dunajská Streda',
          'value' => 'Dunajská Streda',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 17,
        ),
        18 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Fiľakovo',
          'value' => 'Fiľakovo',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 18,
        ),
        19 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Galanta',
          'value' => 'Galanta',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 19,
        ),
        20 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Gbely',
          'value' => 'Gbely',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 20,
        ),
        21 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Gelnica',
          'value' => 'Gelnica',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 21,
        ),
        22 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Giraltovce',
          'value' => 'Giraltovce',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 22,
        ),
        23 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Handlová',
          'value' => 'Handlová',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 23,
        ),
        24 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Hanušovce nad Topľou',
          'value' => 'Hanušovce nad Topľou',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 24,
        ),
        25 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Hlohovec',
          'value' => 'Hlohovec',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 25,
        ),
        26 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Hnúšťa',
          'value' => 'Hnúšťa',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 26,
        ),
        27 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Holíč',
          'value' => 'Holíč',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 27,
        ),
        28 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Hriňová',
          'value' => 'Hriňová',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 28,
        ),
        29 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Humenné',
          'value' => 'Humenné',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 29,
        ),
        30 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Hurbanovo',
          'value' => 'Hurbanovo',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 30,
        ),
        31 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Ilava',
          'value' => 'Ilava',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 31,
        ),
        32 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Jelšava',
          'value' => 'Jelšava',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 32,
        ),
        33 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Kežmarok',
          'value' => 'Kežmarok',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 33,
        ),
        34 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Kolárovo',
          'value' => 'Kolárovo',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 34,
        ),
        35 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Komárno',
          'value' => 'Komárno',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 35,
        ),
        36 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Košice',
          'value' => 'Košice',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 36,
        ),
        37 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Kráľovský Chlmec',
          'value' => 'Kráľovský Chlmec',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 37,
        ),
        38 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Krásno nad Kysucou',
          'value' => 'Krásno nad Kysucou',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 38,
        ),
        39 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Kremnica',
          'value' => 'Kremnica',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 39,
        ),
        40 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Krompachy',
          'value' => 'Krompachy',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 40,
        ),
        41 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Krupina',
          'value' => 'Krupina',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 41,
        ),
        42 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Kysucké Nové Mesto',
          'value' => 'Kysucké Nové Mesto',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 42,
        ),
        43 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Leopoldov',
          'value' => 'Leopoldov',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 43,
        ),
        44 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Levice',
          'value' => 'Levice',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 44,
        ),
        45 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Levoča',
          'value' => 'Levoča',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 45,
        ),
        46 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Lipany',
          'value' => 'Lipany',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 46,
        ),
        47 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Liptovský Hrádok',
          'value' => 'Liptovský Hrádok',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 47,
        ),
        48 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Liptovský Mikuláš',
          'value' => 'Liptovský Mikuláš',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 48,
        ),
        49 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Lučenec',
          'value' => 'Lučenec',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 49,
        ),
        50 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Malacky',
          'value' => 'Malacky',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 50,
        ),
        51 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Martin',
          'value' => 'Martin',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 51,
        ),
        52 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Medzev',
          'value' => 'Medzev',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 52,
        ),
        53 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Medzilaborce',
          'value' => 'Medzilaborce',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 53,
        ),
        54 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Michalovce',
          'value' => 'Michalovce',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 54,
        ),
        55 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Modra',
          'value' => 'Modra',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 55,
        ),
        56 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Modrý Kameň',
          'value' => 'Modrý Kameň',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 56,
        ),
        57 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Moldava nad Bodvou',
          'value' => 'Moldava nad Bodvou',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 57,
        ),
        58 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Myjava',
          'value' => 'Myjava',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 58,
        ),
        59 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Námestovo',
          'value' => 'Námestovo',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 59,
        ),
        60 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Nemšová',
          'value' => 'Nemšová',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 60,
        ),
        61 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Nitra',
          'value' => 'Nitra',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 61,
        ),
        62 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Nová Baňa',
          'value' => 'Nová Baňa',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 62,
        ),
        63 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Nová Dubnica',
          'value' => 'Nová Dubnica',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 63,
        ),
        64 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Nováky',
          'value' => 'Nováky',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 64,
        ),
        65 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Nové Mesto nad Váhom',
          'value' => 'Nové Mesto nad Váhom',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 65,
        ),
        66 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Nové Zámky',
          'value' => 'Nové Zámky',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 66,
        ),
        67 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Partizánske',
          'value' => 'Partizánske',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 67,
        ),
        68 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Pezinok',
          'value' => 'Pezinok',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 68,
        ),
        69 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Piešťany',
          'value' => 'Piešťany',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 69,
        ),
        70 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Podolínec',
          'value' => 'Podolínec',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 70,
        ),
        71 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Poltár',
          'value' => 'Poltár',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 71,
        ),
        72 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Poprad',
          'value' => 'Poprad',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 72,
        ),
        73 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Považská Bystrica',
          'value' => 'Považská Bystrica',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 73,
        ),
        74 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Prešov',
          'value' => 'Prešov',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 74,
        ),
        75 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Prievidza',
          'value' => 'Prievidza',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 75,
        ),
        76 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Púchov',
          'value' => 'Púchov',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 76,
        ),
        77 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Rajec',
          'value' => 'Rajec',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 77,
        ),
        78 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Rajecké Teplice',
          'value' => 'Rajecké Teplice',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 78,
        ),
        79 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Revúca',
          'value' => 'Revúca',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 79,
        ),
        80 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Rimavská Sobota',
          'value' => 'Rimavská Sobota',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 80,
        ),
        81 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Rožňava',
          'value' => 'Rožňava',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 81,
        ),
        82 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Ružomberok',
          'value' => 'Ružomberok',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 82,
        ),
        83 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Sabinov',
          'value' => 'Sabinov',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 83,
        ),
        84 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Šahy',
          'value' => 'Šahy',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 84,
        ),
        85 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Šaľa',
          'value' => 'Šaľa',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 85,
        ),
        86 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Šamorín',
          'value' => 'Šamorín',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 86,
        ),
        87 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Šaštín Stráže',
          'value' => 'Šaštín Stráže',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 87,
        ),
        88 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Sečovce',
          'value' => 'Sečovce',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 88,
        ),
        89 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Senec',
          'value' => 'Senec',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 89,
        ),
        90 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Senica',
          'value' => 'Senica',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 90,
        ),
        91 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Sereď',
          'value' => 'Sereď',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 91,
        ),
        92 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Skalica',
          'value' => 'Skalica',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 92,
        ),
        93 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Sládkovičovo',
          'value' => 'Sládkovičovo',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 93,
        ),
        94 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Sliač',
          'value' => 'Sliač',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 94,
        ),
        95 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Snina',
          'value' => 'Snina',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 95,
        ),
        96 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Sobrance',
          'value' => 'Sobrance',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 96,
        ),
        97 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Spišská Belá',
          'value' => 'Spišská Belá',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 97,
        ),
        98 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Spišská Nová Ves',
          'value' => 'Spišská Nová Ves',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 98,
        ),
        99 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Spišská Stará Ves',
          'value' => 'Spišská Stará Ves',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 99,
        ),
        100 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Spišské Podhradie',
          'value' => 'Spišské Podhradie',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 100,
        ),
        101 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Spišské Vlachy',
          'value' => 'Spišské Vlachy',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 101,
        ),
        102 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Stará Ľubovňa',
          'value' => 'Stará Ľubovňa',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 102,
        ),
        103 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Stará Turá',
          'value' => 'Stará Turá',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 103,
        ),
        104 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Strážske',
          'value' => 'Strážske',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 104,
        ),
        105 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Stropkov',
          'value' => 'Stropkov',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 105,
        ),
        106 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Stupava',
          'value' => 'Stupava',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 106,
        ),
        107 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Štúrovo',
          'value' => 'Štúrovo',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 107,
        ),
        108 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Šurany',
          'value' => 'Šurany',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 108,
        ),
        109 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Svätý Jur',
          'value' => 'Svätý Jur',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 109,
        ),
        110 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Svidník',
          'value' => 'Svidník',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 110,
        ),
        111 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Svit',
          'value' => 'Svit',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 111,
        ),
        112 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Tisovec',
          'value' => 'Tisovec',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 112,
        ),
        113 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Tlmače',
          'value' => 'Tlmače',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 113,
        ),
        114 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Topoľčany',
          'value' => 'Topoľčany',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 114,
        ),
        115 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Tornaľa',
          'value' => 'Tornaľa',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 115,
        ),
        116 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Trebišov',
          'value' => 'Trebišov',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 116,
        ),
        117 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Trenčianske Teplice',
          'value' => 'Trenčianske Teplice',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 117,
        ),
        118 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Trenčín',
          'value' => 'Trenčín',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 118,
        ),
        119 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Trnava',
          'value' => 'Trnava',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 119,
        ),
        120 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Trstená',
          'value' => 'Trstená',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 120,
        ),
        121 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Turčianske Teplice',
          'value' => 'Turčianske Teplice',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 121,
        ),
        122 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Tvrdošín',
          'value' => 'Tvrdošín',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 122,
        ),
        123 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Veľké Kapušany',
          'value' => 'Veľké Kapušany',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 123,
        ),
        124 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Veľký Krtíš',
          'value' => 'Veľký Krtíš',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 124,
        ),
        125 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Veľký Meder',
          'value' => 'Veľký Meder',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 125,
        ),
        126 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Veľký Šariš',
          'value' => 'Veľký Šariš',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 126,
        ),
        127 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Vráble',
          'value' => 'Vráble',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 127,
        ),
        128 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Vranov nad Topľou',
          'value' => 'Vranov nad Topľou',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 128,
        ),
        129 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Vrbové',
          'value' => 'Vrbové',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 129,
        ),
        130 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Vrútky',
          'value' => 'Vrútky',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 130,
        ),
        131 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Vysoké Tatry',
          'value' => 'Vysoké Tatry',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 131,
        ),
        132 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Žarnovica',
          'value' => 'Žarnovica',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 132,
        ),
        133 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Želiezovce',
          'value' => 'Želiezovce',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 133,
        ),
        134 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Žiar nad Hronom',
          'value' => 'Žiar nad Hronom',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 134,
        ),
        135 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Žilina',
          'value' => 'Žilina',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 135,
        ),
        136 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Zlaté Moravce',
          'value' => 'Zlaté Moravce',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 136,
        ),
        137 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Zvolen',
          'value' => 'Zvolen',
          'calc' => '',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'order' => 137,
        ),
      ),
      'container_class' => 'florp-class florp-right florp-registration-field',
      'element_class' => 'florp_school_city',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '<p class="school_city_warning">Ak mesto pôsobenia nevyplníte, Váš flashmob sa na mape nezobrazí.</p>',
      'manual_key' => '1',
      'drawerDisabled' => '',
      'label' => 'Mesto',
      'key' => 'school_city',
      'type' => 'listselect',
    ),
    206 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '10',
      'label_pos' => 'default',
      'required' => '',
      'default' => '',
      'placeholder' => '',
      'container_class' => 'florp-class florp-left florp-registration-field',
      'element_class' => 'florp_user_pass',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '<p><br></p>',
      'desc_text' => '<p>Vyplňte, iba ak chcete heslo zmeniť<br></p>',
      'drawerDisabled' => '',
      'label' => 'Heslo',
      'key' => 'user_pass',
      'type' => 'password',
    ),
    207 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '11',
      'label_pos' => 'default',
      'required' => '',
      'default' => '',
      'placeholder' => '',
      'container_class' => 'florp-class florp-right florp-registration-field',
      'element_class' => 'florp_passwordconfirm',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '<p>Vyplňte, iba ak chcete heslo zmeniť<br></p>',
      'confirm_field' => 'user_pass',
      'drawerDisabled' => '',
      'label' => 'Potvrďte heslo',
      'key' => 'passwordconfirm',
      'type' => 'passwordconfirm',
    ),
    208 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '12',
      'container_class' => 'florp-class florp-subscriber-type-field_flashmob_organizer',
      'element_class' => '',
      'drawerDisabled' => '',
      'label' => 'Divider',
      'key' => 'hr_1499212471823',
      'type' => 'hr',
    ),
    209 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '13',
      'default' => '<h5>Ďalšie informácie</h5>',
      'container_class' => 'florp-class florp-subscriber-type-field_flashmob_organizer',
      'element_class' => '',
      'drawerDisabled' => '',
      'label' => 'Nadpis: ďalšie info',
      'key' => 'nadpis_dalsie_info_1523963911637',
      'type' => 'html',
    ),
    210 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '14',
      'label_pos' => 'default',
      'required' => '0',
      'default' => '{usermeta:school_name}',
      'placeholder' => '',
      'container_class' => 'florp-class florp-left florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp_school_name',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'disable_browser_autocomplete' => '',
      'mask' => '',
      'custom_mask' => '',
      'drawerDisabled' => '',
      'custom_name_attribute' => '',
      'label' => 'Meno školy (skupiny)',
      'key' => 'school_name',
      'type' => 'textbox',
    ),
    211 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '15',
      'label_pos' => 'default',
      'required' => '0',
      'default' => '{usermeta:school_webpage}',
      'placeholder' => 'http://example.com',
      'container_class' => 'florp-class florp-right florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp_school_webpage',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'disable_browser_autocomplete' => '',
      'mask' => '',
      'custom_mask' => '',
      'drawerDisabled' => '',
      'custom_name_attribute' => '',
      'label' => 'Webstránka / FB link školy (skupiny)',
      'key' => 'school_webpage',
      'type' => 'textbox',
    ),
    212 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '16',
      'container_class' => 'florp-class florp-subscriber-type-field_flashmob_organizer',
      'element_class' => '',
      'drawerDisabled' => '',
      'label' => 'Divider',
      'key' => 'hr_1499212477071',
      'type' => 'hr',
    ),
    213 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '17',
      'default' => '<h5 class="florp-flashmob-info-h5">Info o flashmobe</h5>

<p class="florp-flashmob-info-p florp-before-flashmob">Nasledujúce položky sa budú dať vyplniť po uskutočnení flashmobu.</p>',
      'container_class' => 'florp-class florp-flashmob florp-subscriber-type-field_flashmob_organizer',
      'element_class' => '',
      'drawerDisabled' => '',
      'label' => 'Nadpis: flashmob',
      'key' => 'nadpis_flashmob_1499213672394',
      'type' => 'html',
    ),
    214 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '18',
      'label_pos' => 'default',
      'default' => '{usermeta:flashmob_number_of_dancers}',
      'placeholder' => '',
      'container_class' => 'florp-class florp-flashmob florp-left florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp_flashmob_number_of_dancers',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'product_assignment' => '',
      'num_min' => '',
      'num_max' => '',
      'num_step' => '1',
      'drawerDisabled' => '',
      'label' => 'Počet tancujúcich',
      'key' => 'flashmob_number_of_dancers',
      'type' => 'quantity',
    ),
    215 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '19',
      'label_pos' => 'default',
      'required' => '',
      'options' => 
      array (
        0 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => '0',
          'label' => 'Youtube',
          'value' => 'youtube',
          'calc' => '',
          'selected' => '0',
          'order' => '0',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'manual_value' => '1',
        ),
        1 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => '0',
          'order' => '1',
          'new' => '',
          'options' => 
          array (
          ),
          'label' => 'Facebook',
          'value' => 'facebook',
          'calc' => '',
          'selected' => '0',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'manual_value' => '1',
        ),
        2 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => '0',
          'order' => '2',
          'new' => '',
          'options' => 
          array (
          ),
          'label' => 'Vimeo',
          'value' => 'vimeo',
          'calc' => '',
          'selected' => '0',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'manual_value' => '1',
        ),
        3 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => '0',
          'order' => '3',
          'new' => '',
          'options' => 
          array (
          ),
          'label' => 'Iné',
          'value' => 'other',
          'calc' => '',
          'selected' => '0',
          'settingModel' => 
          array (
            'settings' => false,
            'hide_merge_tags' => false,
            'error' => false,
            'name' => 'options',
            'type' => 'option-repeater',
            'label' => 'Options <a href="#" class="nf-add-new">Add New</a> <a href="#" class="extra nf-open-import-tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i> Import</a>',
            'width' => 'full',
            'group' => '',
            'value' => 
            array (
              0 => 
              array (
                'label' => 'One',
                'value' => 'one',
                'calc' => '',
                'selected' => 0,
                'order' => 0,
              ),
              1 => 
              array (
                'label' => 'Two',
                'value' => 'two',
                'calc' => '',
                'selected' => 0,
                'order' => 1,
              ),
              2 => 
              array (
                'label' => 'Three',
                'value' => 'three',
                'calc' => '',
                'selected' => 0,
                'order' => 2,
              ),
            ),
            'columns' => 
            array (
              'label' => 
              array (
                'header' => 'Label',
                'default' => '',
              ),
              'value' => 
              array (
                'header' => 'Value',
                'default' => '',
              ),
              'calc' => 
              array (
                'header' => 'Calc Value',
                'default' => '',
              ),
              'selected' => 
              array (
                'header' => '<span class="dashicons dashicons-yes"></span>',
                'default' => 0,
              ),
            ),
          ),
          'manual_value' => '1',
        ),
      ),
      'container_class' => 'florp-class florp-flashmob florp-right florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp-video-type-select florp_video_link_type',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'manual_key' => '1',
      'drawerDisabled' => '',
      'label' => 'Typ videa',
      'key' => 'video_link_type',
      'type' => 'listselect',
    ),
    216 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '20',
      'label_pos' => 'default',
      'required' => '',
      'default' => '{usermeta:youtube_link}',
      'placeholder' => 'https://www.youtube.com/watch?v=',
      'container_class' => 'florp-class florp-flashmob florp-video florp-video-youtube florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp_youtube_link',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '<p><br></p>',
      'desc_text' => '<p>V tvare https://www.youtube.com/watch?v=[video_ID]</p>',
      'disable_browser_autocomplete' => '',
      'mask' => '',
      'custom_mask' => '',
      'drawerDisabled' => '',
      'custom_name_attribute' => '',
      'label' => 'Youtube link',
      'key' => 'youtube_link',
      'type' => 'textbox',
    ),
    217 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '21',
      'label_pos' => 'default',
      'required' => '',
      'default' => '{usermeta:facebook_link}',
      'placeholder' => 'https://www.facebook.com/[pozivatel]/videos/[video_ID]/',
      'container_class' => 'florp-class florp-flashmob florp-video florp-video-facebook florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp_facebook_link',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '<p><br></p>',
      'desc_text' => '<p>V tvare https://www.facebook.com/[pozivatel]/videos/[video_ID]/</p>',
      'disable_browser_autocomplete' => '',
      'mask' => '',
      'custom_mask' => '',
      'drawerDisabled' => '',
      'custom_name_attribute' => '',
      'label' => 'Facebook video link',
      'key' => 'facebook_link',
      'type' => 'textbox',
    ),
    218 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '22',
      'label_pos' => 'default',
      'required' => '',
      'default' => '{usermeta:vimeo_link}',
      'placeholder' => 'http://vimeo.com/[video_ID]',
      'container_class' => 'florp-class florp-flashmob florp-video florp-video-vimeo florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp_vimeo_link',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '<p><br></p>',
      'desc_text' => '<p>V tvare http://vimeo.com/[video_ID]</p>',
      'disable_browser_autocomplete' => '',
      'mask' => '',
      'custom_mask' => '',
      'drawerDisabled' => '',
      'custom_name_attribute' => '',
      'label' => 'Vimeo video link',
      'key' => 'vimeo_link',
      'type' => 'textbox',
    ),
    219 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '23',
      'label_pos' => 'default',
      'required' => '',
      'default' => '{usermeta:embed_code}',
      'placeholder' => '',
      'container_class' => 'florp-class florp-flashmob florp-video florp-video-other florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp_embed_code',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '<p>Prosíme, nastavte embed kód na veľkosť 280x160.</p>',
      'disable_browser_autocomplete' => '',
      'textarea_rte' => '',
      'disable_rte_mobile' => '',
      'textarea_media' => '',
      'drawerDisabled' => '',
      'label' => 'Embedovací kód',
      'key' => 'embed_code',
      'type' => 'textarea',
    ),
    220 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '24',
      'label_pos' => 'default',
      'required' => '0',
      'default' => '{usermeta:flashmob_address}',
      'placeholder' => '',
      'container_class' => 'florp-class florp-flashmob florp-left-with-button florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp-flashmob-address florp_flashmob_address',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '<p>Vyplňte miesto, kde ste uskutočnili rueda flashmob a kliknite na "Nájdi" pre kontrolu a prípadné upresnenie pozície. Mapa, ktorá sa zobrazí, ukazuje, ako sa vaše údaje zobrazia aj na mape na webstránke.</p><br />
<br />
<p class="flashmob_address_warning">Ak nevyplníte aspoň jedno z polí "mesto flashmobu", "miesto konania flashmobu", Váš flashmob sa na mape nezobrazí.</p>',
      'disable_browser_autocomplete' => '',
      'mask' => '',
      'custom_mask' => '',
      'drawerDisabled' => '',
      'custom_name_attribute' => 'address',
      'label' => 'Miesto konania flashmobu',
      'key' => 'flashmob_address',
      'type' => 'address',
    ),
    221 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '25',
      'default' => '<span class="florp-button button florp-button-find-location">Nájdi</span>',
      'container_class' => 'florp-class florp-flashmob florp-right-button florp-subscriber-type-field_flashmob_organizer',
      'element_class' => '',
      'drawerDisabled' => '',
      'label' => 'Nájdi',
      'key' => 'najdi_1499219575360',
      'type' => 'html',
    ),
    222 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '26',
      'default' => '<div class="florp-map-preview-wrapper">
  <div class="nf-field-description">
    <p>Pre upresnenie pozície ťahajte značku.</p>


  </div>


  <div class="florp-map-preview"></div>


</div>',
      'container_class' => 'florp-class florp-flashmob florp-subscriber-type-field_flashmob_organizer',
      'element_class' => '',
      'drawerDisabled' => '',
      'label' => 'MAP wrapper div',
      'key' => 'map_wrapper_div_1499222834794',
      'type' => 'html',
    ),
    223 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '27',
      'label_pos' => 'default',
      'required' => '',
      'default' => '{usermeta:longitude}',
      'placeholder' => '',
      'container_class' => 'florp-class florp-left florp-flashmob florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp_longitude',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '1',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'disable_browser_autocomplete' => '',
      'mask' => '',
      'custom_mask' => '',
      'drawerDisabled' => '',
      'custom_name_attribute' => '',
      'label' => 'Zemepisná dĺžka',
      'key' => 'longitude',
      'type' => 'textbox',
    ),
    224 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '28',
      'label_pos' => 'default',
      'required' => '',
      'default' => '{usermeta:latitude}',
      'placeholder' => '',
      'container_class' => 'florp-class florp-right florp-flashmob florp-subscriber-type-field_flashmob_organizer',
      'element_class' => 'florp_latitude',
      'input_limit' => '',
      'input_limit_type' => 'characters',
      'input_limit_msg' => 'Character(s) left',
      'manual_key' => '1',
      'disable_input' => '1',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'disable_browser_autocomplete' => '',
      'mask' => '',
      'custom_mask' => '',
      'drawerDisabled' => '',
      'custom_name_attribute' => '',
      'label' => 'Zemepisná šírka',
      'key' => 'latitude',
      'type' => 'textbox',
    ),
    225 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '29',
      'container_class' => 'florp-class florp-antispam florp-registration-field',
      'element_class' => '',
      'size' => 'visible',
      'drawerDisabled' => '',
      'label' => 'Antispamová ochrana',
      'key' => 'antispamova_ochrana_1523974918099',
      'type' => 'recaptcha_logged-out-only',
    ),
    226 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => '',
      'order' => '30',
      'processing_label' => 'Processing',
      'container_class' => 'florp-class florp-registration-field',
      'element_class' => 'florp_uloz_profil florp-button button',
      'drawerDisabled' => '',
      'label' => 'Ulož',
      'key' => 'uloz_1499114572027',
      'type' => 'submit',
    ),
  ),
  'action_settings' => 
  array (
    32 => 
    array (
      'title' => '',
      'key' => '',
      'type' => 'save',
      'active' => '1',
      'created_at' => '2018-03-31 14:05:52',
      'drawerDisabled' => '',
      'from_address' => '',
      'email_format' => 'html',
      'cc' => '',
      'bcc' => '',
      'attach_csv' => '',
      'redirect_url' => '',
      'from_name' => '',
      'email_message_plain' => '',
      'email_message' => '{fields_table}',
      'email_subject' => 'Ninja Forms Submission',
      'reply_to' => '',
      'to' => '{wp:admin_email}',
      'tag' => '',
      'payment_total' => '0',
      'payment_gateways' => '',
      'order' => '3',
      'label' => 'Save Submission',
      'editActive' => '',
      'objectDomain' => 'actions',
      'objectType' => 'Action',
      'payment_total_type' => '',
    ),
    33 => 
    array (
      'title' => '',
      'key' => '',
      'type' => 'email',
      'active' => '1',
      'created_at' => '2018-03-31 14:05:52',
      'email_message' => '{fields_table}',
      'email_message_plain' => '',
      'from_name' => '{field:first_name} {field:last_name}',
      'from_address' => 'info@salsarueda.dance',
      'email_format' => 'html',
      'cc' => '',
      'bcc' => '',
      'attach_csv' => '1',
      'email_subject' => 'Bol vyplnený profil organizátora flashmobu',
      'reply_to' => '',
      'tag' => '',
      'payment_total' => '0',
      'payment_gateways' => '',
      'order' => '2',
      'message' => '{field:all_fields}',
      'subject' => 'Ninja Forms Submission',
      'to' => 'charliecek@gmail.com',
      'label' => 'Admin Email: Kajo',
      'editActive' => '',
      'objectDomain' => 'actions',
      'objectType' => 'Action',
      'payment_total_type' => '',
      'drawerDisabled' => '',
    ),
    34 => 
    array (
      'title' => NULL,
      'key' => NULL,
      'type' => 'success-message-logged-in',
      'active' => '1',
      'created_at' => '2018-03-31 18:49:27',
      'objectType' => 'Action',
      'objectDomain' => 'actions',
      'editActive' => '',
      'label' => 'Success Message (Logged In)',
      'payment_gateways' => '',
      'payment_total' => '0',
      'tag' => '',
      'to' => '{wp:admin_email}',
      'reply_to' => '',
      'email_subject' => 'Ninja Forms Submission',
      'email_message' => '{fields_table}',
      'email_message_plain' => '',
      'from_name' => '',
      'from_address' => '',
      'email_format' => 'html',
      'cc' => '',
      'bcc' => '',
      'redirect_url' => '',
      'success_msg' => '<span class="florp_success_message">Profil bol úspešne uložený.</span>',
      'drawerDisabled' => '',
    ),
    35 => 
    array (
      'title' => NULL,
      'key' => NULL,
      'type' => 'success-message-logged-out',
      'active' => '1',
      'created_at' => '2018-03-31 18:49:27',
      'objectType' => 'Action',
      'objectDomain' => 'actions',
      'editActive' => '',
      'label' => 'Success Message (Logged Out)',
      'payment_gateways' => '',
      'payment_total' => '0',
      'tag' => '',
      'to' => '{wp:admin_email}',
      'reply_to' => '',
      'email_subject' => 'Ninja Forms Submission',
      'email_message' => '{fields_table}',
      'email_message_plain' => '',
      'from_name' => '',
      'from_address' => '',
      'email_format' => 'html',
      'cc' => '',
      'bcc' => '',
      'redirect_url' => '',
      'success_msg' => '<span class="florp_success_message">Registrácia prebehla úspešne.</span>',
      'drawerDisabled' => '',
    ),
    36 => 
    array (
      'title' => '',
      'key' => '',
      'type' => 'florp',
      'active' => '1',
      'created_at' => '2018-03-31 14:05:52',
      'cc' => '',
      'bcc' => '',
      'attach_csv' => '',
      'redirect_url' => '',
      'success_msg' => 'Your form has been successfully submitted.',
      'drawerDisabled' => '',
      'email_format' => 'html',
      'from_address' => '',
      'from_name' => '',
      'email_message_plain' => '',
      'email_message' => '{fields_table}',
      'email_subject' => 'Ninja Forms Submission',
      'reply_to' => '',
      'to' => '{wp:admin_email}',
      'tag' => '',
      'payment_total' => '0',
      'payment_gateways' => '',
      'label' => 'FestSRD: Organizer profile validation',
      'editActive' => '',
      'objectDomain' => 'actions',
      'objectType' => 'Action',
      'payment_total_type' => '',
    ),
  ),
); ?>