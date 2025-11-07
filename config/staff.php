<?php

return [
    // List emails for Staff Cohort 2025 to notify on new student inquiries.
    // You can populate via .env as a comma-separated list, e.g.:
    // STAFF_COHORT_2025_EMAILS="staff1@example.com,staff2@example.com"
    'cohort_2025_emails' => array_values(array_filter(array_map('trim', explode(',', env('STAFF_COHORT_2025_EMAILS', ''))))),
];
