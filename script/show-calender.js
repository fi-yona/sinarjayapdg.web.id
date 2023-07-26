$(function() {
    var currentYear = new Date().getFullYear();
    var startYear = currentYear - 100; // Start year (100 years ago from the current year)
    var endYear = currentYear;
    $(".tanggal-penugasan").datepicker({
        changeYear: true, // Enable year selection
        yearRange: startYear + ':' + endYear, // Custom year range
        dateFormat: 'yy-mm-dd' // Date format
    });
    $(".tanggal-search").datepicker({
        changeYear: true, // Enable year selection
        yearRange: startYear + ':' + endYear, // Custom year range
        dateFormat: 'yy-mm-dd' // Date format
    });
});
