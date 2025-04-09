<?php
  header('Content-Type: application/json'); // Make sure the browser knows this is JSON

  $receiving_email_address = 'sheak.imran2010@gmail.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    echo json_encode([
      'ok' => false,
      'error' => 'Unable to load the PHP Email Form library.'
    ]);
    exit;
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;

  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];

  $contact->add_message( $_POST['name'], 'From');
  $contact->add_message( $_POST['email'], 'Email');
  if(isset($_POST['phone'])) {
    $contact->add_message( $_POST['phone'], 'Phone');
  }
  $contact->add_message( $_POST['message'], 'Message', 10);

  if ($contact->send()) {
    echo json_encode([
      'ok' => true,
      'next' => '/thanks?language=en'
    ]);
  } else {
    echo json_encode([
      'ok' => false,
      'error' => 'Failed to send message.'
    ]);
  }
?>
