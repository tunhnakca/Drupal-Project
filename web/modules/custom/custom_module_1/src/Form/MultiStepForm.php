<?php

/**
 * @file
 * Contains Drupal\drupalbook\Form\MultiStepForm.
 */

namespace Drupal\custom_module_1\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MultiStepForm extends FormBase
{

  protected $step = 1;

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
  }

  /**
   * {@inheritdoc}
   */
  public function getFormID()
  {
    return 'multi_step_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    //$form = parent::buildForm($form, $form_state);

    // Add a wrapper div that will be used by the Form API to update the form using AJAX
    $form['#prefix'] = '<div id="ajax_form_multistep_form">';
    $form['#suffix'] = '</div>';
    if ($this->step == 1) {
      $form['message-step'] = [
        '#markup' => '<div class="step">' . $this->t('Step 1 of 2') . '</div>',
      ];
      $form['message-title'] = [
        '#markup' => '<h2>' . $this->t('Who are you?') . '</h2>',
      ];
      $form['first_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('First name'),
        '#placeholder' => $this->t('First name'),
        '#required' => TRUE,
      ];
      $form['last_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Last name'),
        '#placeholder' => $this->t('Last name'),
        '#required' => TRUE,
      ];

    }

    if ($this->step == 2) {
      $form['message-step'] = [
        '#markup' => '<div class="step">' . $this->t('Step 2 of 2') . '</div>',
      ];
      $form['message-title'] = [
        '#markup' => '<h2>' . $this->t('Please enter your contact details below:') . '</h2>',
      ];
      $form['phone'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Phone'),
        '#placeholder' => $this->t('Phone'),
        '#required' => TRUE,
      ];
      $form['email'] = [
        '#type' => 'email',
        '#title' => $this->t('Email address'),
        '#placeholder' => $this->t('Email address'),
        '#attributes' => array('class' => array('mail-first-step')),
        '#required' => TRUE,
      ];
      $form['subscribe'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Subscribe to newsletter'),
      ];
      $form['agree'] = [
        '#markup' => '<p class="agree">' . $this->t(' By signing up you agree to the <a href="@terms">Terms and Conditions</a> and <a href="@policy">Privacy Policy</a>',
            array('@terms' => '/terms-and-conditions', '@policy' => '/privacy-policy')) . '</p>',
      ];
    }

    if ($this->step == 3) {
      $form['message-step'] = [
        '#markup' => '<p class="complete">' . $this->t('- Complete -') . '</p>',
      ];
      $form['message-title'] = [
        '#markup' => '<h2>' . $this->t('Thank you') . '</h2>',
      ];

    }

    if ($this->step == 1) {
      $form['buttons']['forward'] = array(
        '#type' => 'submit',
        '#value' => t('Next'),
        '#prefix' => '<div class="step1-button">',
        '#suffix' => '</div>',

      );
    }
    if ($this->step == 2) {
      $form['buttons']['forward'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),

      );
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    return parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($this->step == 2) {
      $values = $form_state->getValues();
      $email = $values['email'];
      // Save data or send email here.
    }

    $this->step++;
    $form_state->setRebuild();
  }

  public function ajax_form_multistep_form_ajax_callback(array &$form, FormStateInterface $form_state) {
    return $form;
  }

}