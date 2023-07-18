import './bootstrap';

// resources/js/app.js
import $ from 'jquery';
window.$ = window.jQuery = $;

// Other imports and custom JavaScript code

// Initialize DataTables
$(document).ready(function () {
    $('#product-table').DataTable();
});
