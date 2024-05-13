<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once dirname(__FILE__) . '/../index.php';

//Load Composer's autoloader
require BASE_DIR . '/vendor/autoload.php';

function filter_field($value, $type, $required)
{
    $filter = FILTER_DEFAULT;

    if ($type == 'email') {
        $filter = FILTER_SANITIZE_EMAIL;
    }

    $value = filter_var(htmlspecialchars($value), $filter);

    if ($required && empty($value)) {
        return false;
    } else if ($type == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    return true;
}

function send_mail(
    $auth,
    $from,
    $to,
    $subject,
    $body
) {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer();

    //Server settings
    $mail->isSMTP();
    $mail->Host       = $auth['host'];
    $mail->Username   = $auth['username'];
    $mail->Password   = $auth['password'];
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->CharSet = "UTF-8";

    //Recipients
    $mail->setFrom($auth['username']);
    $mail->addAddress($to);
    $mail->addReplyTo($from);

    //Content
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->IsHTML(true);

    $mail->send();
}

function render_form_fields($fields)
{
    $in_row = false;

    foreach ($fields as $name => $field) {
        $prev_in_row = $in_row;
        $in_row = $field['in_row'] ?? false;

        // Logic to display fields in columns
        if ($in_row) {
            // If in row
            if (!$prev_in_row) {
                // If previous was not in row, open row
                echo '<div class="mb-3 row g-3 row-cols-1 row-cols-md-2">';
            }
            // Render field as a column
            echo "<div class='col field-$name'>";
            render_form_field($name, $field);
            echo "</div>";
        } else {
            // If not in row
            if ($prev_in_row) {
                // If previous was in row, close row
                echo '</div>';
            }
            // Render field wrapped by simple margin
            echo '<div class="mb-3">';
            render_form_field($name, $field);
            echo '</div>';
        }
    }
}

function render_form_field($name, $field)
{

    $label = $field['label'] ?? '';
    $placeholder = $field['placeholder'] ?? '';
    $type = $field['type'];
    $required = (isset($field['required']) && $field['required']) ? 'required' : '';
    $autocomplete = $field['autocomplete'] ?? $name;
    $attrs = $field['attrs'] ?? '';

    if ($placeholder)
        $attrs .= " placeholder='$placeholder'";
    
    $attrs .= " autocomplete='$autocomplete'";

    if ($label)
        echo "<label for='$name'>$label</label>";

    if ($type == 'textarea')
        echo "<textarea name='$name' class='form-control' $required $attrs></textarea>";
    else if ($type == 'select') {
        echo "<select name='$name' class='form-select' $required $attrs>";

        $options = $field['options'] ?? [];

        $first_option = ($label != '') ? $label : $placeholder;
        echo "<option selected disabled>$first_option</option>";

        foreach ($options as $option) {
            echo "<option value='". htmlspecialchars($option)."'>".htmlspecialchars($option)."</option>";
        }

        echo "</select>";
    } else
        echo "<input type='$type' name='$name' class='form-control' $required $attrs>";

    echo '<div class="invalid-feedback"></div>';
}

function render_honeypot($name)
{
    $field = [
        'label' => '',
        'placeholder' => 'Fax Number',
        'type' => 'number',
        'required' => 'false',
        'attrs' => 'style="margin: 0; height: 16px; opacity: 0; cursor: default;" aria-hidden="true"'
    ];
    
    render_form_field($name, $field);
}
