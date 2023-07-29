<?php

/**
 * @file
 * Contains Drupal\custom_module_1\Form\CustomModuleForm.
 */

namespace Drupal\custom_module_1\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MultiStepForm2 extends FormBase {
    
    public function getFormId() {
        return 'multi_step_form_2';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['#prefix'] = '<div id="ajax_form_multistep_form">';
        $form['#suffix'] = '</div>';
        if($form_state->get('step') == NULL){
            $form_state->set('step',1);
        }

        $step =  $form_state->get('step');
        $form['info1'] =  [
            '#markup' => "$step of 3",
            
        ];

        if($form_state->get('step') == 1){
           
            
            $form['isim'] = [
                '#type' => 'textfield',
                '#title' => $this->t('isim'),
                '#required' => TRUE // bu alanı zorunlu yapar
            ];
        }

        if($form_state->get('step') == 2){
            
            $form['mesaj'] =  [
                '#type' => 'textarea',
                '#title' => $this->t('mesaj'),
                '#required' => TRUE // bu alanı zorunlu yapar
            ];
        }

        if($form_state->get('step') == 3){
            $ad = $form_state->get('isim');
            $mesaj = $form_state->getValue('mesaj');
            $form['info'] =  [
                '#markup' => "isminiz $ad mesajınız $mesaj",
            ];
        }
    
        $form['submit'] =  [
            '#type' => 'submit',
            '#value' => $this->t('next'),
            '#ajax' => array(
                // We pass in the wrapper we created at the start of the form
                'wrapper' => 'ajax_form_multistep_form',
                // We pass a callback function we will use later to render the form for the user
                'callback' => '::ajax_form_multistep_form_ajax_callback',
               
              ),
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        $isim = $form_state->getValue('isim');
        if ($isim == 'murat'){
            $form_state->setErrorByName('isim', $this->t('isminiz murat olamaz.'));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {

    if($form_state->get('step') == 1){
        $form_state->set('isim', $form_state->getValue('isim'));
    }
      $step =  $form_state->get('step') + 1;
            $form_state->set('step', $step);
            $form_state->setRebuild();
    }
    public function ajax_form_multistep_form_ajax_callback(array &$form, FormStateInterface $form_state) {
        \Drupal::logger('my_module')->error(print_r($form,true));
        
        return $form;
      }
}