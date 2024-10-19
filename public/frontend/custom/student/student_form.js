var ajax_table;
var tableContainer;
var StudentForm = (function () {
    ////////////////////////// Begins Action Events /////////////////////////
    var initFormComponents = function () {
        $(document).ready(function () {
            flatpickr(".datepicker", {
                dateFormat: "d/m/Y",
            });
        });
    };

    return {
        handleFormValid: function () {
            initFormComponents();
        },
    };
})();
