# Email Playbook for Internship System

This document provides a step‑by‑step, copy‑paste friendly guide to add, send, and troubleshoot emails (mailables) in this Laravel application. It is designed so future contributors can implement new emails consistently and reliably.

Applies to: Laravel 12, PHP 8.2+

Table of contents
- Prerequisites and configuration
- Choosing synchronous vs queued delivery
- Creating a new Mailable
- Building the email Blade template
- Sending the email (controller/service)
- Triggering via Events and Listeners (optional)
- Testing emails (feature/unit)
- Observability and logs
- Troubleshooting checklist
- Secure secrets and environment matrix
- Implementation checklist (TL;DR)

## 1) Prerequisites and configuration

1. Configure a mailer in .env:
   - For development, Mailpit (or MailHog) is simplest. Example using Mailpit:
     - MAIL_MAILER=smtp
     - MAIL_HOST=127.0.0.1
     - MAIL_PORT=1025
     - MAIL_USERNAME=null
     - MAIL_PASSWORD=null
     - MAIL_ENCRYPTION=null
     - MAIL_FROM_ADDRESS="no-reply@example.test"
     - MAIL_FROM_NAME="Internship System"
   - For production, use your SMTP provider (e.g., SES, SendGrid, Mailgun). Keep APP_ENV=production and set a real from address.

2. Verify the configuration:
   - php artisan tinker
     - use Illuminate\Support\Facades\Mail;
     - Mail::raw('test', fn($m)=>$m->to('you@example.com')->subject('Test'));
   - Or send any existing mailable from a temporary route/controller.

3. Ensure queues are configured (only if you plan to queue emails):
   - QUEUE_CONNECTION=database (recommended for simple setups) or redis
   - php artisan queue:table && php artisan migrate (if using database driver)
   - Run a worker in dev: php artisan queue:work (or queue:listen)

## 2) Choose delivery mode: send() vs queue()

- Immediate (synchronous): Mail::to($user)->send(new YourMailable($data));
  - Pros: simplest; no worker needed; instant feedback.
  - Cons: adds latency to the request.

- Queued (asynchronous): Mail::to($user)->queue(new YourMailable($data));
  - Pros: non‑blocking; resilient retries.
  - Cons: requires correct queue setup and a running worker.

- Recommendation for this project:
  - Use send() by default for critical flows (e.g., registration confirmations) unless the controller path is performance‑sensitive and a worker is guaranteed to be running.

## 3) Create a new Mailable

1. Generate the class (example: StudentRegistered):
   - php artisan make:mail StudentRegistered --markdown=mail.student-registered

2. Inject the domain model/data via constructor and expose it to the view using the Content::with() API:

   Example (app/Mail/StudentRegistered.php):

   <?php
   namespace App\Mail;
   use App\Models\Student;
   use Illuminate\Bus\Queueable;
   use Illuminate\Mail\Mailable;
   use Illuminate\Mail\Mailables\Content;
   use Illuminate\Mail\Mailables\Envelope;
   use Illuminate\Queue\SerializesModels;

   class StudentRegistered extends Mailable
   {
       use Queueable, SerializesModels;

       public Student $student;

       public function __construct(Student $student)
       {
           $this->student = $student;
       }

       public function envelope(): Envelope
       {
           return new Envelope(subject: 'Student Registered');
       }

       public function content(): Content
       {
           return new Content(
               markdown: 'mail.student-registered',
               with: [ 'student' => $this->student ],
           );
       }
   }

3. Subject lines, reply‑to, and from can be customized in envelope():
   - return new Envelope(subject: 'Welcome', replyTo: 'support@example.com');

4. Attachments (optional): override attachments(): array and return Attachment instances.

## 4) Build the email Blade template

- Location: resources/views/mail/<name>.blade.php
- Use Laravel Markdown components for consistent styling:

  <x-mail::message>
  # Hi {{ $student->full_name }}

  Your registration was successful.

  <x-mail::button :url="config('app.url')">Open site</x-mail::button>

  Thanks,
  {{ config('app.name') }}
  </x-mail::message>

- Keep templates idempotent and use existing model properties (e.g., Student uses full_name, not name).

## 5) Send the email from your controller/service

- Minimal synchronous example:

  use Illuminate\Support\Facades\Mail;
  use App\Mail\StudentRegistered as StudentRegisteredMail;

  Mail::to($recipientEmail)->send(new StudentRegisteredMail($student));

- Queued example (requires worker):

  Mail::to($recipientEmail)->queue(new StudentRegisteredMail($student));

- Where to get $recipientEmail:
  - From the model (e.g., $student->email) or a configured address.

- Current project convention:
  - For Student registration, we dispatch the StudentRegistered event and also send the StudentRegistered mailable synchronously in StudentController::store().

## 6) Triggering via Events and Listeners (optional)

- Use events to decouple domain actions from notifications.

1. Create an Event:
   - php artisan make:event StudentRegistered
   - Include the relevant data (e.g., Student $student) in the constructor.

2. Create a Listener (if you want the listener to send the email):
   - php artisan make:listener SendStudentRegisteredEmail --event=StudentRegistered

3. Register the event/listener in app/Providers/EventServiceProvider.php (if not auto‑discovered).

4. In your domain code, dispatch the event:
   - event(new StudentRegistered($student));

5. In the listener handle() method, send or queue the mailable.

- Note: If you choose listeners to send emails, you must ensure a queue worker is running when using ShouldQueue on the listener.

## 7) Testing emails

1. Feature test using MAIL_MAILER=array:
   - In phpunit.xml or in the test, set mailer to array to capture messages:
     - config(['mail.default' => 'array']);

2. Use Mail fake for unit/feature tests:

   use Illuminate\Support\Facades\Mail;
   use Tests\TestCase;
   use App\Mail\StudentRegistered as StudentRegisteredMail;

   Mail::fake();
   // perform action that should send mail
   Mail::assertSent(StudentRegisteredMail::class, function ($m) use ($student) {
       return $m->student->is($student);
   });

3. Snapshot rendering (optional):
   - $html = (new StudentRegisteredMail($student))->render();
   - Assert view contains expected strings.

## 8) Observability and logs

- All outgoing emails are logged by Laravel when APP_DEBUG=true. Check storage/logs/laravel.log for errors.
- For SMTP issues, enable low‑level debugging if supported by provider, or use a local catcher like Mailpit to inspect.
- Consider adding a Mail sending failure listener if you need metrics.

## 9) Troubleshooting checklist

- Not receiving email:
  - Is MAIL_MAILER and SMTP config correct for the environment?
  - If using queue(): Is a worker running? Check php artisan queue:work logs.
  - Do you see errors in storage/logs/laravel.log?
  - Is the recipient address valid and allowed by the provider (sandbox domains)?
  - SPF/DKIM not set in production? Configure DNS to prevent spam filtering.

- Template errors (undefined variable or property):
  - Ensure your mailable passes data via Content::with([...]).
  - Ensure Blade template references correct property names (e.g., full_name).

- Performance / timeouts:
  - Prefer queue() for heavy templates or slow SMTP; ensure worker capacity and retries are configured.

- Duplicated sends:
  - Check event listeners for multiple handlers or double dispatch.

## 10) Secure secrets and environment matrix

- Never commit real SMTP credentials. Use .env and environment variables.
- For non‑production environments, prefer a dev mailer (Mailpit) and a clearly fake from domain.
- Keep distinct .env values per environment and document them in your deployment system.

## 11) Implementation checklist (TL;DR)

- [ ] Decide send() vs queue() and ensure queue worker is available if choosing queue().
- [ ] Create mailable via artisan and pass required data in constructor.
- [ ] Build a Markdown Blade template under resources/views/mail/.
- [ ] Wire the send in controller/service or via event listener.
- [ ] Verify MAIL_* settings locally (use Mailpit) and in each environment.
- [ ] Add tests (Mail::fake and assertSent).
- [ ] Monitor logs, and validate delivery in the target inbox.

Appendix: Useful commands
- php artisan make:mail WelcomeUser --markdown=mail.welcome-user
- php artisan make:event SomethingHappened
- php artisan make:listener SendWelcomeUserEmail --event=SomethingHappened
- php artisan queue:table && php artisan migrate
- php artisan queue:work
