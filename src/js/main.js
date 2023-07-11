import 'bootstrap';
import './quill';

(jQuery)(
    function ($) {
        var saveConfirmation = document.getElementById('saveConfirmation');
        if (saveConfirmation !== null) {
            var unsavedChanges = false;
            var submittingForm = false;
            
            $('input, textarea').change(function () {
                if (!unsavedChanges) unsavedChanges = true;
            });

            // Check if click is to submit form
            document.addEventListener('click', function (e) {
                submittingForm = ($(e.target).attr('type') === 'submit');
            });

            // Show confirmation message before page is unloaded, 
            // if there are unsaved changes and form is not being submitted.
            window.addEventListener('beforeunload', function (e) {
                if (unsavedChanges && !submittingForm) {
                    var confirmationMsg = 'There are unsaved changes. Are you sure you want to leave?'
                    e.preventDefault();
                    e.returnValue = confirmationMsg;
                    return confirmationMsg;
                }
            });
        }

        $('.password-toggle').click(function () {
            $(this).toggleClass('bi-eye');
            var type = $(this).siblings('input').attr('type') == 'password'
                ? 'text'
                : 'password';

            $(this).siblings('input').attr('type', type);
        });
    }
)