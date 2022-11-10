<?php

namespace Drupal\example_forms\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an example form.
 */
class UserRegistrationForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'example_forms';
  }
  // Creating a unique id of the form.

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['user_name'] = [
      '#type' => 'tel',
      '#title' => $this->t('Your user name'),
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Register'),
      '#button_type' => 'primary',
    ];
    return $form;
  }
  // Form Fields are getting created.

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('user_name')) < 3) {
      $form_state->setErrorByName('user_name', $this->t('The user name should only be alphanumeric without special chars.'));
    }
  }
  // Validations of the form field

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('Your user name is @name', ['@name' => $form_state->getValue('user_name')]));
  }
  // Submit form, saving of data is being taken care of!

}
