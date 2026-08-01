/* LIBAS E KHAS - ADMIN JAVASCRIPT */

$(document).ready(function() {
    "use strict";

    // Toggle Sidebar
    $('#sidebarCollapse').on('click', function() {
        $('.admin-sidebar').toggleClass('active');
        $('.admin-content').toggleClass('active');
    });

    // Close sidebar on mobile when clicking outside (simple implementation)
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            $('.admin-sidebar').removeClass('active');
            $('.admin-content').removeClass('active');
        }
    });

    // Initialize DataTables if table exists
    if ($('.datatable').length > 0) {
        $('.datatable').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records..."
            },
            drawCallback: function() {
                $('.dataTables_paginate > .pagination').addClass('pagination-sm');
            }
        });
    }

    // Chart.js Demo Initialization (if canvas exists)
    if ($('#revenueChart').length > 0) {
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue (PKR)',
                    data: [150000, 220000, 180000, 310000, 290000, 450000],
                    borderColor: '#C5A059', // Gold
                    backgroundColor: 'rgba(197, 160, 89, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
