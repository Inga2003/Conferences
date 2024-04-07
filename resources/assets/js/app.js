import './bootstrap';

// Use flatpickr to initialize datepicker on elements with 'datepicker' class
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.datepicker').forEach(function(item) {
        flatpickr(item, {
            mode: 'range'
        });
    });
});


