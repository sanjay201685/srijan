<?php

/**
 * @file
 * Contains \Drupal\restrictip\Plugin\Block\RestrictIpBlock.
 */
namespace Drupal\restrictip\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\file\Entity\File;

/**
 * Restrict block on the basis of Ip.
 *
 * @Block(
 *   id = "restrictip_block",
 *   admin_label = @Translation("Restrict ip block"),
 *   category = @Translation("Restrict ip block")
 * )
 */
class RestrictIpBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $config = $this->getConfiguration();
    
    $build = [];
    $build['#theme'] = 'block__restrictip_block';
    $build['#title'] = !empty($config['title']) ? $config['title'] : '';
    
    // Fetch image configuration.
    $image = $this->configuration['image'];
    if (!empty($image[0])) {
      if ($file = File::load($image[0])) {
        $build['#image'] = [
          '#theme' => 'image_style',
          '#style_name' => 'medium',
          '#uri' => $file->getFileUri(),
        ];
      }
    }

    $build['#description'] = !empty($config['description']) ? $config['description'] : '';
    
    return $build;
  }
  
  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account, $return_as_object = FALSE) {
    $config = $this->getConfiguration();
    $ip_add =  $config['ip_add'];
    $current_ip = \Drupal::request()->getClientIp();
    
    // If set ip and current ip both are same return false.
    if (!empty($ip_add) && $ip_add === $current_ip) {
      return \Drupal\Core\Access\AccessResult::allowedIf(FALSE);
    }
    else {
      return \Drupal\Core\Access\AccessResult::allowedIf($account->isAuthenticated());   
    }
  }
  
  /**
  * {@inheritdoc}
  */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => isset($config['title']) ? $config['title'] : '',
      '#required' => true,
    );
    
    $form['image'] = array(
      '#type' => 'managed_file',
      '#upload_location' => 'public://upload/files',
      '#title' => t('Image'),
      '#upload_validators' => [
        'file_validate_extensions' => ['jpg', 'jpeg', 'png', 'gif']
      ],
      '#default_value' => isset($this->configuration['image']) ? $this->configuration['image'] : '',
      '#description' => t('Upload image type jpg, jpeg, png, gif'),
      '#required' => true,
    );
    
    $form['description'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => isset($config['description']) ? $config['description'] : '',
      '#required' => true,
    );
    
    $form['ip_add'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('IP Addess'),
      '#default_value' => isset($config['ip_add']) ? $config['ip_add'] : '',
    );
    
    $form['#theme'] = 'block__restrictip';
  
    return $form;
  }

  /**
  * {@inheritdoc}
  */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save image as permanent.
    $image = $form_state->getValue('image');
    if ($image != $this->configuration['image']) {
      if (!empty($image[0])) {
        $file = File::load($image[0]);
        $file->setPermanent();
        $file->save();
      }
    }
    
    // Save data in configuration.
    $this->configuration['title'] = $form_state->getValue('title');
    $this->configuration['image'] = $form_state->getValue('image');
    $this->configuration['description'] = $form_state->getValue('description');
    $this->configuration['ip_add'] = $form_state->getValue('ip_add');
  }
}
