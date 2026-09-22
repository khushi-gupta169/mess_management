document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    // Initialize DataTables
    if ($.fn.DataTable) {
        $('.table').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records...",
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        });
    }

    // Initialize charts
    if (typeof Chart !== 'undefined') {
        // Meal attendance chart
        const mealCtx = document.getElementById('mealAttendanceChart');
        if (mealCtx) {
            const mealData = {
                labels: ['Breakfast', 'Lunch', 'Dinner'],
                datasets: [{
                    label: 'Meal Attendance',
                    data: [mealCtx.dataset.breakfast, mealCtx.dataset.lunch, mealCtx.dataset.dinner],
                    backgroundColor: [
                        'rgba(23, 162, 184, 0.2)',
                        'rgba(40, 167, 69, 0.2)',
                        'rgba(255, 193, 7, 0.2)'
                    ],
                    borderColor: [
                        'rgba(23, 162, 184, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(255, 193, 7, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            new Chart(mealCtx, {
                type: 'bar',
                data: mealData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Payment summary chart
        const paymentCtx = document.getElementById('paymentSummaryChart');
        if (paymentCtx) {
            const paymentData = {
                labels: ['Monthly Collection', 'Total Due'],
                datasets: [{
                    data: [paymentCtx.dataset.collection, paymentCtx.dataset.due],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.2)',
                        'rgba(220, 53, 69, 0.2)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            new Chart(paymentCtx, {
                type: 'doughnut',
                data: paymentData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        }
    }

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Tooltip initialization
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Date picker initialization
    if ($.fn.datepicker) {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    }

    // Custom file input
    $('.custom-file-input').on('change', function() {
        const fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Confirmation dialogs for delete actions
    $('.confirm-delete').on('click', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');

        if (confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
            form.submit();
        }
    });
});