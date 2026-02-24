<?php

if (!function_exists('generate_invoice_number')) {
    function generate_invoice_number()
    {
        return 'INV-' . time();
    }
}
