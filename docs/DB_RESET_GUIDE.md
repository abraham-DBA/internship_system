DB reset guide for Students

If you want to drop existing student records and start fresh, you have two options depending on how broadly you want to reset data.

Option A) Truncate only the students data (keep other tables intact)
- php artisan tinker
- >>> \DB::statement('TRUNCATE TABLE students');

This keeps your migrations as-is and only clears student rows.

Option B) Full reset of ALL tables via migrations (drops everything, then re-runs migrations)
Warning: This will delete ALL data in your database (users, password resets, etc.). Back up first if needed.

Steps
1) Stop running workers/servers
   - queue workers, horizon, schedule, etc.
2) (Optional but recommended) Backup your database
3) Run fresh migrations
   - php artisan migrate:fresh --force
   - If you have seeders you want to run automatically: php artisan migrate:fresh --seed --force
4) Clear caches
   - php artisan optimize:clear
5) Verify schema
   - php artisan migrate:status
   - Ensure columns exist on students: student_email, status, supervisor_name, supervisor_email

Notes on this project
- Migrations present:
  - 2025_11_06_212928_create_students_table.php
  - 2025_11_07_041100_add_fields_to_students_table.php (adds student_email, status, supervisor_name, supervisor_email)
- After a fresh migration, Students will have the above columns.
- The public / page form already includes a required Student Email field and posts to route name student.save which stores status='pending' and sends a confirmation email.

Post-reset sanity checks
- Visit /
  - Submit the form with Full Name, Reg Number, Program, Organization, Contact, Student Email.
- Login and visit /dashboard
  - Total/Pending/Approved counts should reflect the new submission.
- Approve a student on their Show page and ensure the approval email with attachment is sent.

Production caution
- Only use migrate:fresh in non-production or when you have explicit downtime and backups. For production shape changes, prefer normal php artisan migrate.
