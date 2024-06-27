import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'datatables.net';
import 'datatables.net-bs4';

$(function() {
    $('#product-table').DataTable();
});


require('jquery');
require('datatables.net');
require('datatables.net-bs4');
