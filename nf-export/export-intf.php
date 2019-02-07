<?php if ( ! defined( 'ABSPATH' ) ) exit;
$aFlorpNinjaFormExportData = array (
  'form_settings' => 
  array (
    'objectType' => 'Form Setting',
    'editActive' => true,
    'title' => 'International rueda flashmob participant signup form',
    'created_at' => '2019-02-03 14:30:21',
    'form_title' => 'Rueda flashmob participant signup form - copy',
    'default_label_pos' => 'left',
    'show_title' => '0',
    'clear_complete' => '0',
    'hide_complete' => '0',
    'logged_in' => '0',
    'fieldNumberNumMaxError' => '',
    'fieldNumberIncrementBy' => '',
    'formErrorsCorrectErrors' => 'Prosíme, opravte chyby',
    'validateRequiredField' => 'Toto pole je povinné',
    'fieldsMarkedRequired' => 'Polia označené <span class="ninja-forms-req-symbol">*</span> sú povinné.',
    'currency' => '',
    'not_logged_in_msg' => '',
    'sub_limit_msg' => 'The Form has reached it\'s submission limit.',
    'calculations' => 
    array (
    ),
    'honeypotHoneypotError' => '',
    'formContentData' => 
    array (
      0 => 'html_1528847274101',
      1 => 'intf_city',
      2 => 'first_name',
      3 => 'last_name',
      4 => 'user_email',
      5 => 'gender',
      6 => 'dance_level',
      7 => 'flashmob_city',
      8 => 'preferences',
      9 => 'html_-_newsletter_banner_mobile_1535795671381',
      10 => 'upozornenie_1537461842330',
      11 => 'html_-_newsletter_banner_1533390855929',
      12 => 'flashmob_participant_tshirt_gender',
      13 => 'flashmob_participant_tshirt_size',
      14 => 'flashmob_participant_tshirt_color',
      15 => 'antispamova_ochrana_1528848098448',
      16 => 'save_button',
    ),
    'drawerDisabled' => false,
    'unique_field_error' => 'A form with this value has already been submitted.',
    'fieldNumberNumMinError' => '',
    'confirmFieldErrorMsg' => 'Tieto polia musia byť rovnaké!',
    'changeEmailErrorMsg' => 'Prosíme, zadajte platnú emailovú adresu!',
    'add_submit' => '1',
    'element_class' => '',
    'wrapper_class' => '',
    'key' => '',
    'changeDateErrorMsg' => '',
  ),
  'field_settings' => 
  array (
    271 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 1,
      'default' => '<p>Zadané údaje nie sú nikde zverejnené.<br></p>',
      'container_class' => 'florp-class florp-registration-field florp-intf florp-75p',
      'element_class' => '',
      'drawerDisabled' => false,
      'label' => 'HTML',
      'key' => 'html_1528847274101',
      'type' => 'html',
    ),
    285 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 2,
      'type' => 'listselect',
      'label' => 'Hlasujte za mesto medzinárodného flashmobu',
      'key' => 'intf_city',
      'label_pos' => 'left',
      'required' => 1,
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
          'label' => 'vyberte mesto',
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
      ),
      'container_class' => 'florp-class florp-full-uniform florp_intf_city florp-registration-field florp-clear-on-submission florp-intf',
      'element_class' => 'florp_intf_city',
      'admin_label' => '',
      'help_text' => '',
      'drawerDisabled' => false,
      'manual_key' => true,
    ),
    284 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 3,
      'personally_identifiable' => '1',
      'label_pos' => 'default',
      'required' => '1',
      'default' => '',
      'placeholder' => '',
      'container_class' => 'florp-class florp-left florp-registration-field florp-clear-on-submission florp-intf',
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
    283 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 4,
      'personally_identifiable' => '1',
      'label_pos' => 'default',
      'required' => '1',
      'default' => '',
      'placeholder' => '',
      'container_class' => 'florp-class florp-right florp-registration-field florp-clear-on-submission florp-intf',
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
    282 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 5,
      'personally_identifiable' => '1',
      'label_pos' => 'default',
      'required' => '1',
      'default' => '',
      'placeholder' => '',
      'container_class' => 'florp-class florp-left florp-registration-field florp-clear-on-submission florp-intf',
      'element_class' => 'florp_user_email',
      'admin_label' => '',
      'help_text' => '',
      'desc_text' => '',
      'drawerDisabled' => '',
      'manual_key' => '1',
      'custom_name_attribute' => 'email',
      'label' => 'Email',
      'key' => 'user_email',
      'type' => 'email',
    ),
    278 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 6,
      'label_pos' => 'left',
      'required' => '1',
      'options' => 
      array (
        0 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Muž',
          'value' => 'muz',
          'calc' => '0',
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
          'label' => 'Žena',
          'value' => 'zena',
          'calc' => '0',
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
      'container_class' => 'florp-class florp-right florp-gender florp-registration-field florp-clear-on-submission florp-multi-columns florp-intf',
      'element_class' => 'gender',
      'admin_label' => '',
      'help_text' => '',
      'manual_key' => '1',
      'drawerDisabled' => '',
      'label' => 'Pohlavie',
      'key' => 'gender',
      'type' => 'listradio',
    ),
    276 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 7,
      'type' => 'listselect',
      'label' => 'Tanečná úroveň',
      'key' => 'dance_level',
      'drawerDisabled' => '',
      'manual_key' => '1',
      'help_text' => '',
      'admin_label' => '',
      'element_class' => 'florp_dance_level',
      'container_class' => 'florp-class florp-left florp_dance_level florp-registration-field florp-clear-on-submission florp-intf',
      'label_pos' => 'left',
      'required' => '0',
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
          'label' => 'vyberte úroveň',
          'value' => 'null',
          'calc' => '0',
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
          'label' => 'Začiatočník (do 3 mesiacov)',
          'value' => 'zaciatocnik',
          'calc' => '0',
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
        2 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Mierne pokročilý (do roka)',
          'value' => 'mierne_pokrocily',
          'calc' => '0',
          'selected' => 0,
          'order' => 2,
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
        3 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Stredne pokročilý (do 2 rokov)',
          'value' => 'stredne_pokrocily',
          'calc' => '0',
          'selected' => 0,
          'order' => 3,
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
        4 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'order' => 4,
          'new' => false,
          'options' => 
          array (
          ),
          'label' => 'Pokročilý',
          'value' => 'pokrocily',
          'calc' => '0',
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
        5 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'order' => 5,
          'new' => false,
          'options' => 
          array (
          ),
          'label' => 'Expert',
          'value' => 'expert',
          'calc' => '0',
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
        6 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'order' => 6,
          'new' => false,
          'options' => 
          array (
          ),
          'label' => 'Učiteľ',
          'value' => 'ucitel',
          'calc' => '0',
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
      ),
    ),
    277 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 8,
      'container_class' => 'florp-class florp-right florp_flashmob_city florp-registration-field florp-clear-on-submission florp-intf',
      'element_class' => 'florp_flashmob_city',
      'admin_label' => '',
      'help_text' => '',
      'manual_key' => '1',
      'drawerDisabled' => false,
      'label' => 'Mesto (kde tancujete)',
      'key' => 'flashmob_city',
      'type' => 'listselect',
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
          'label' => 'vyberte mesto',
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
      'required' => '1',
      'label_pos' => 'left',
    ),
    281 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 9,
      'container_class' => 'florp-class florp-profile-field florp_preferences_container florp-clear-on-submission florp-multi-columns florp-multi-columns-2 florp-columns-like-right-left florp-intf',
      'element_class' => 'florp_preferences',
      'admin_label' => '',
      'help_text' => '<p>Kedykoľvek budete chcieť newsletter zrušiť, môžete tak spraviť kliknutím na odkaz v pätičke ľubovoľného emailu alebo nás kontaktujte na info@salsarueda.dance.</p><p>Vaše informácie budeme rešpektovať a používať výlučne ku kontaktovaniu a zasielaniu noviniek tohoto webu. K vaším údajom bude mať prístup iba majiteľ tohoto webu a nebude ich poskytovať iným osobám.</p><p>Spracovanie týchto údajov nám povoľuje zákon GDPR a tieto údaje budeme uchovávať po dobu existencie tohoto webu alebo kým si Vy nevyžiadate zmazanie z databázy.</p><p>Máte právo byť jednoducho vymazaný z databázy, právo na presun údajov a právo na prístup k informáciám ktoré o vás tento web zhromaždil.</p>',
      'manual_key' => '1',
      'drawerDisabled' => false,
      'desc_text' => '',
      'label' => 'Preferencie',
      'key' => 'preferences',
      'type' => 'listcheckbox',
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
          'label' => 'Chcem pamätné Flashmob tričko',
          'value' => 'flashmob_participant_tshirt',
          'calc' => '0',
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
          'label' => 'Chcem dostávať newsletter',
          'value' => 'newsletter_subscribe',
          'calc' => '0',
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
    ),
    270 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 10,
      'drawerDisabled' => '',
      'key' => 'html_-_newsletter_banner_mobile_1535795671381',
      'element_class' => '',
      'container_class' => 'florp-class florp-right florp-registration-field florp-mobile florp-intf',
      'default' => '<p class="florp-newsletter-banner participants">  <a href="http://festivaly.salsarueda.dance/newsletters/nl-latest.html" target="_blank"><img src="/wpsite/wp-content/plugins/flashmob-organizer-profile/img/newsletter-banner.jpg" alt="newsletter" title="newsletter"></a></p>',
      'type' => 'html',
      'label' => 'HTML - newsletter banner Mobile',
    ),
    268 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 11,
      'type' => 'html',
      'label' => 'Upozornenie',
      'default' => '<p><b>Upozornenie!</b> Tričká objednané po %%iTshirtOrderDeliveredBeforeFlashmobDdlDate%% budú dodané po flashmobe.</p>',
      'container_class' => 'florp-class florp-left florp-preference-field_flashmob_participant_tshirt florp-tshirt-after-flashmob-warning florp-intf',
      'element_class' => '',
      'key' => 'upozornenie_1537461842330',
      'drawerDisabled' => false,
    ),
    269 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 12,
      'label' => 'HTML - newsletter banner',
      'type' => 'html',
      'key' => 'html_-_newsletter_banner_1533390855929',
      'element_class' => '',
      'drawerDisabled' => '',
      'container_class' => 'florp-class florp-right florp-registration-field florp-desktop florp-intf',
      'default' => '<p class="florp-newsletter-banner participants">
  <a href="http://festivaly.salsarueda.dance/newsletters/nl-latest.html" target="_blank"><img src="/wpsite/wp-content/plugins/flashmob-organizer-profile/img/newsletter-banner.jpg" alt="newsletter" title="newsletter"></a>
</p>',
    ),
    279 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 13,
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
          'label' => 'Mužské',
          'value' => 'muz',
          'calc' => '0',
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
        1 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'Ženské',
          'value' => 'zena',
          'calc' => '0',
          'selected' => 0,
          'order' => 2,
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
      'container_class' => 'florp-class florp-left florp-preference-field_flashmob_participant_tshirt florp-clear-on-submission florp-multi-columns florp-intf',
      'element_class' => 'flashmob_participant_tshirt_gender',
      'admin_label' => '',
      'help_text' => '',
      'manual_key' => '1',
      'drawerDisabled' => '',
      'label' => 'Typ trička',
      'key' => 'flashmob_participant_tshirt_gender',
      'type' => 'listradio',
    ),
    280 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 14,
      'element_class' => 'flashmob_participant_tshirt_size',
      'container_class' => 'florp-class florp-left florp-preference-field_flashmob_participant_tshirt florp-clear-on-submission florp-intf',
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
          'label' => 'vyberte veľkosť',
          'value' => 'null',
          'calc' => '0',
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
          'order' => 1,
          'new' => false,
          'options' => 
          array (
          ),
          'label' => 'XS',
          'value' => 'XS',
          'calc' => '0',
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
        2 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'S',
          'value' => 'S',
          'calc' => '0',
          'selected' => 0,
          'order' => 2,
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
        3 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'M',
          'value' => 'M',
          'calc' => '0',
          'selected' => 0,
          'order' => 3,
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
        4 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'order' => 4,
          'new' => false,
          'options' => 
          array (
          ),
          'label' => 'L',
          'value' => 'L',
          'calc' => '0',
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
        5 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'order' => 5,
          'new' => false,
          'options' => 
          array (
          ),
          'label' => 'XL',
          'value' => 'XL',
          'calc' => '0',
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
        6 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'order' => 6,
          'new' => false,
          'options' => 
          array (
          ),
          'label' => 'XXL',
          'value' => 'XXL',
          'calc' => '0',
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
      ),
      'admin_label' => '',
      'help_text' => '',
      'manual_key' => '1',
      'drawerDisabled' => false,
      'label' => 'Veľkosť trička',
      'key' => 'flashmob_participant_tshirt_size',
      'type' => 'listselect',
    ),
    272 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 15,
      'key' => 'flashmob_participant_tshirt_color',
      'type' => 'listradio',
      'label' => 'Farba trička',
      'drawerDisabled' => false,
      'element_class' => 'flashmob_participant_tshirt_color',
      'container_class' => 'florp-class florp-left florp-preference-field_flashmob_participant_tshirt florp-clear-on-submission florp-multi-columns florp-participant-tshirt-color florp-multi-columns-max-2 florp-intf',
      'manual_key' => '1',
      'help_text' => '',
      'admin_label' => '',
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
          'label' => 'cierne',
          'value' => 'black',
          'calc' => '0',
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
        1 => 
        array (
          'errors' => 
          array (
          ),
          'max_options' => 0,
          'label' => 'biele',
          'value' => 'white',
          'calc' => '0',
          'selected' => 0,
          'order' => 2,
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
    ),
    275 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 17,
      'container_class' => 'florp-class florp-antispam florp-registration-field florp-intf',
      'element_class' => '',
      'size' => 'visible',
      'drawerDisabled' => false,
      'label' => 'Antispamová ochrana',
      'key' => 'antispamova_ochrana_1528848098448',
      'type' => 'recaptcha_logged-out-only',
    ),
    274 => 
    array (
      'objectType' => 'Field',
      'objectDomain' => 'fields',
      'editActive' => false,
      'order' => 18,
      'manual_key' => '1',
      'processing_label' => 'Processing',
      'container_class' => 'florp-class florp-registration-field florp-button-wrapper florp-intf',
      'element_class' => 'florp_uloz_profil florp-button button',
      'drawerDisabled' => false,
      'label' => 'Ulož',
      'key' => 'save_button',
      'type' => 'submit',
    ),
  ),
  'action_settings' => 
  array (
    56 => 
    array (
      'title' => '',
      'key' => '',
      'type' => 'save',
      'active' => '1',
      'created_at' => '2019-02-03 14:30:21',
      'fields-save-toggle' => 'save_all',
      'submitter_email' => '',
      'message' => 'This action adds users to WordPress\' personal data export tool, allowing admins to comply with the GDPR and other privacy regulations from the site\'s front end.',
      'exception_fields' => 
      array (
      ),
      'subs_expire_time' => '90',
      'set_subs_to_expire' => '0',
      'drawerDisabled' => '',
      'from_address' => '',
      'email_format' => 'html',
      'bcc' => '',
      'cc' => '',
      'redirect_url' => '',
      'attach_csv' => '',
      'from_name' => '',
      'email_message' => '{fields_table}',
      'email_message_plain' => '',
      'email_subject' => 'Ninja Forms Submission',
      'reply_to' => '',
      'to' => '{wp:admin_email}',
      'payment_total' => '0',
      'tag' => '',
      'payment_gateways' => '',
      'label' => 'Save Submission',
      'order' => '3',
      'editActive' => '',
      'objectType' => 'Action',
      'objectDomain' => 'actions',
      'payment_total_type' => '',
    ),
    53 => 
    array (
      'title' => '',
      'key' => '',
      'type' => 'email',
      'active' => '1',
      'created_at' => '2019-02-03 14:30:21',
      'from_name' => '{field:first_name} {field:last_name}',
      'from_address' => 'info@salsarueda.dance',
      'cc' => '',
      'email_format' => 'html',
      'bcc' => '',
      'attach_csv' => '1',
      'reply_to' => '',
      'email_subject' => 'Bol prihlásený účastník flashmobu',
      'tag' => '',
      'message' => '{field:all_fields}',
      'order' => '2',
      'payment_gateways' => '',
      'payment_total' => '0',
      'to' => 'charliecek@gmail.com',
      'subject' => 'Ninja Forms Submission',
      'editActive' => '',
      'label' => 'Admin Email: Kajo',
      'objectType' => 'Action',
      'objectDomain' => 'actions',
      'payment_total_type' => '',
      'drawerDisabled' => '',
      'email_message_plain' => '',
      'email_message' => '{fields_table}',
    ),
    54 => 
    array (
      'title' => NULL,
      'key' => NULL,
      'type' => 'successmessage',
      'active' => '1',
      'created_at' => '2019-02-03 14:30:21',
      'fields-save-toggle' => 'save_all',
      'submitter_email' => '',
      'exception_fields' => 
      array (
      ),
      'set_subs_to_expire' => '0',
      'subs_expire_time' => '90',
      'message' => 'This action adds users to WordPress\' personal data export tool, allowing admins to comply with the GDPR and other privacy regulations from the site\'s front end.',
      'drawerDisabled' => '',
      'bcc' => '',
      'success_msg' => '<span class="florp_success_message">Prihlásenie prebehlo úspešne.</span>',
      'cc' => '',
      'redirect_url' => '',
      'email_format' => 'html',
      'from_address' => '',
      'email_message_plain' => '',
      'from_name' => '',
      'email_message' => '{fields_table}',
      'email_subject' => 'Ninja Forms Submission',
      'reply_to' => '',
      'to' => '{wp:admin_email}',
      'tag' => '',
      'payment_total' => '0',
      'payment_gateways' => '',
      'label' => 'Success Message',
      'objectType' => 'Action',
      'objectDomain' => 'actions',
      'editActive' => '',
    ),
    55 => 
    array (
      'title' => NULL,
      'key' => NULL,
      'type' => 'closepopup',
      'active' => '1',
      'created_at' => '2019-02-03 14:30:21',
      'message' => 'This action adds users to WordPress\' personal data export tool, allowing admins to comply with the GDPR and other privacy regulations from the site\'s front end.',
      'close_delay' => '3',
      'drawerDisabled' => '',
      'success_msg' => 'Your form has been successfully submitted.',
      'bcc' => '',
      'redirect_url' => '',
      'cc' => '',
      'email_format' => 'html',
      'from_address' => '',
      'email_message_plain' => '',
      'from_name' => '',
      'email_message' => '{fields_table}',
      'reply_to' => '',
      'email_subject' => 'Ninja Forms Submission',
      'tag' => '',
      'to' => '{wp:admin_email}',
      'payment_total' => '0',
      'fields-save-toggle' => 'save_all',
      'submitter_email' => '',
      'objectDomain' => 'actions',
      'objectType' => 'Action',
      'editActive' => '',
      'label' => 'Close Popup',
      'payment_gateways' => '',
      'exception_fields' => 
      array (
      ),
      'set_subs_to_expire' => '0',
      'subs_expire_time' => '90',
    ),
    58 => 
    array (
      'title' => NULL,
      'key' => NULL,
      'type' => 'success-message-logged-out',
      'active' => '0',
      'created_at' => '2019-02-03 14:30:21',
      'drawerDisabled' => '',
      'success_msg' => '<span class="florp_success_message">Registrácia prebehla úspešne.</span>',
      'redirect_url' => '',
      'bcc' => '',
      'cc' => '',
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
      'label' => 'Success Message (Logged Out)',
      'editActive' => '',
      'objectDomain' => 'actions',
      'objectType' => 'Action',
      'message' => 'This action adds users to WordPress\' personal data export tool, allowing admins to comply with the GDPR and other privacy regulations from the site\'s front end.',
      'exception_fields' => 
      array (
      ),
      'fields-save-toggle' => 'save_all',
      'submitter_email' => '',
      'set_subs_to_expire' => '0',
      'subs_expire_time' => '90',
    ),
    57 => 
    array (
      'title' => NULL,
      'key' => NULL,
      'type' => 'success-message-logged-in',
      'active' => '0',
      'created_at' => '2019-02-03 14:30:21',
      'payment_gateways' => '',
      'label' => 'Success Message (Logged In)',
      'payment_total' => '0',
      'tag' => '',
      'reply_to' => '',
      'to' => '{wp:admin_email}',
      'email_subject' => 'Ninja Forms Submission',
      'email_message' => '{fields_table}',
      'from_name' => '',
      'email_message_plain' => '',
      'from_address' => '',
      'subs_expire_time' => '90',
      'email_format' => 'html',
      'message' => 'This action adds users to WordPress\' personal data export tool, allowing admins to comply with the GDPR and other privacy regulations from the site\'s front end.',
      'set_subs_to_expire' => '0',
      'exception_fields' => 
      array (
      ),
      'fields-save-toggle' => 'save_all',
      'submitter_email' => '',
      'drawerDisabled' => '',
      'success_msg' => '<span class="florp_success_message">Profil bol úspešne uložený.</span>',
      'redirect_url' => '',
      'bcc' => '',
      'cc' => '',
      'objectType' => 'Action',
      'objectDomain' => 'actions',
      'editActive' => '',
    ),
    59 => 
    array (
      'title' => '',
      'key' => '',
      'type' => 'florp',
      'active' => '1',
      'created_at' => '2019-02-03 14:30:21',
      'email_subject' => 'Ninja Forms Submission',
      'email_message' => '{fields_table}',
      'email_message_plain' => '',
      'from_name' => '',
      'from_address' => '',
      'email_format' => 'html',
      'drawerDisabled' => '',
      'success_msg' => 'Your form has been successfully submitted.',
      'redirect_url' => '',
      'attach_csv' => '',
      'bcc' => '',
      'cc' => '',
      'payment_total_type' => '',
      'objectType' => 'Action',
      'objectDomain' => 'actions',
      'editActive' => '',
      'label' => 'FestSRD: Organizer profile validation',
      'payment_gateways' => '',
      'payment_total' => '0',
      'tag' => '',
      'to' => '{wp:admin_email}',
      'reply_to' => '',
      'message' => 'This action adds users to WordPress\' personal data export tool, allowing admins to comply with the GDPR and other privacy regulations from the site\'s front end.',
      'submitter_email' => '',
      'fields-save-toggle' => 'save_all',
      'exception_fields' => 
      array (
      ),
      'set_subs_to_expire' => '0',
      'subs_expire_time' => '90',
    ),
  ),
  'version' => 4007002,
  'timestamp' => 1549579675,
); ?>