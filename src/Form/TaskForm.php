<?php

namespace Drupal\task\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TaskForm extends FormBase
{

  public function getFormId()
  {
    return 'task_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['asset_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Select a Asset Type'),
      '#options' => [
        'default' => $this->t('Default'),
        'custom' => $this->t('Custom'),
      ],
      '#ajax' => [
        'callback' => '::selectCallback',
        'wrapper' => 'asset_path',
      ],
    ];
    $form['asset_path'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'asset_path'
      ],
    ];
    if ($form_state->getValue('asset_type', NULL) === "custom") {
      $form['asset_path']['custom_path'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Asset Path'),
      ];
    }
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addStatus($key . ': ' . $value);
    }
  }
  /**
   * @param $form
   * @param FormStateInterface $form_state
   * @return mixed
   */
  public function selectCallback($form, FormStateInterface $form_state)
  {
    return $form['asset_path'];
  }
}
