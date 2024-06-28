// Importing necessary modules
import './bootstrap';
import $ from 'jquery';
import 'datatables.net';
import 'datatables.net-bs4';

// Assigning jQuery to global window object
window.$ = window.jQuery = $;

// Initializing DataTables when the DOM is fully loaded
$(function() {
    $('#product-table').DataTable();
});
