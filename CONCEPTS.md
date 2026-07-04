# Concepts

Shared domain vocabulary for this project — entities, named processes, and status concepts with project-specific meaning. Seeded with core domain vocabulary, then accretes as ce-compound and ce-compound-refresh process learnings; direct edits are fine. Glossary only, not a spec or catch-all.

## Campaign

### Campaign (Kampanye)
A fundraising drive with a target amount and deadline. Each campaign has a unique slug for its public URL, an optional cover image, and a description.
*Avoid:* Penggalangan dana, fundraiser, project

A campaign is considered complete as soon as either its target amount is reached by verified donations or its deadline passes — whichever occurs first. Completion is computed on every read (accessor), not stored as a column; there is no explicit "close" action. A completed campaign stops accepting new donations: its donation form is hidden or disabled.

### Campaign Progress
The ratio of total verified donation amount to the campaign's target amount, capped at 100%. Displayed as both a percentage and a progress bar. Unverified (pending/rejected) donations do not count toward progress.

### Remaining Days
The number of calendar days between now and the campaign deadline. Computed as `max(0, diffInDays(now, deadline, false))`. Once zero or the campaign completes, displays as "Selesai" rather than a countdown.

---

## Donation

### Donation (Donasi / Sumbangan)
A single monetary contribution to a campaign, submitted by a donor without login. Each donation is always tied to exactly one campaign.
*Avoid:* Sumbangan, kontribusi, pembayaran

A donation carries the donor's name, optional contact (email or phone), the IDR amount, and an uploaded proof-of-transfer image. On submission it receives a unique UUID token and enters `pending` status. Only verified donations appear on the public donor list and count toward campaign progress.

### Donation Status
A donation passes through exactly one lifecycle:

```
pending → verified
pending → rejected
```

- **Pending** — submitted by donor, awaiting admin review. Visible only to admin and via token tracking.
- **Verified** — accepted by admin. Verifier timestamp recorded in `verified_at`. Shown on the public donor list and counted toward campaign progress.
- **Rejected** — declined by admin with mandatory notes. Not shown publicly and not counted toward progress. Remain recorded.

Status is stored as a string column; there is no native database enum (kept for SQLite compatibility).

### Token (Token Lacak Donasi)
A UUID v4 string generated when a donation is created, used as the only credential a donor has to track their donation's status. Tokens are unique per donation and not guessable. The public tracking URL is `/cek/{token}`.

### Verification (Verifikasi Donasi)
The admin action of reviewing a pending donation and deciding to accept or reject it. Verification is a single-click action from the admin dashboard, though rejection requires a note explaining why. There is no multi-step approval workflow.

### Proof of Transfer (Bukti Transfer)
The image file a donor uploads when submitting a donation. Validated as an actual image (jpg/png/jpeg) up to 2 MB. Stored in `storage/app/public/donations/`. Admins view the proof inline in the detail page to match it against the claimed amount before verifying.

---

## Admin

### Bank Account (Rekening Tujuan)
A destination bank account where donors should transfer funds. Managed by admin via CRUD. All bank accounts are displayed on every campaign detail page as transfer destinations — there is no per-campaign account assignment. Each account carries a bank name, account holder name, and account number.
*Avoid:* Rekening bank, akun bank, payment destination

### Admin
A user authenticated via Laravel session guard with full, undifferentiated access to the admin panel. One role covers all actions: managing campaigns, verifying donations, and maintaining bank accounts. Admin accounts are created via seeder or tinker (no registration page).

---

## Flagged ambiguities

- "Status donasi" had been used interchangeably for both the donation lifecycle (`pending`/`verified`/`rejected`) and the campaign's completion state — these are distinct concepts captured above.
