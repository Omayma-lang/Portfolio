# Portfolio Website — Project Brief

## Goal
A dynamic (PHP/MySQL, not static) personal portfolio website that gets small business /
individual clients to hire Omayma for freelance work, primarily via platforms like Mostaqil.

## Audience
Small business / individual clients who would hire a freelancer for web dev, UI/UX, or
video work. Design every section (copy, project selection, CTA) around convincing *this*
person specifically — not recruiters, not a general audience.

## Positioning
- **Lead with web development** as the main offer (it has the strongest proof-of-work).
- Frame **UI/UX design** and **video editing** as complementary skills, not three separate
  businesses. Do not pitch all three equally.
- Copy must be **specific**, not generic. Avoid phrases like "full-stack developer" or
  "I build websites." Instead name the kind of client/project targeted, e.g. "I build
  ordering/booking sites for small local businesses," and point directly at the bookstore
  project as proof.
- Do **not** describe her as a student anywhere in the copy.
- Do **not** list specific backend/frontend languages by name in the intro.

## Content Strategy
- Only one finished project exists right now: the **bookstore e-commerce site**
  (okhelfaoui23.atwebpages.com/main.html, PHP/MySQL).
- Present it as a **deep case study**, not a one-line project card: problem → decisions →
  screenshots → tech used → what she'd improve.
- **Do not** add an empty "coming soon" placeholder grid for future projects — it reads as
  inactive, not in-progress. Future projects get added via the admin panel once finished.

## MVP Scope (ship within ~3 weeks)
Build only these for launch:
1. Home / hero
2. Bookstore case study (deep version, see above)
3. About / skills
4. Contact
5. Simple admin panel — a basic form to add new projects/certificates later, **not** a
   full dashboard

**Explicitly deferred to post-launch polish** (do not block launch on these):
- 3D rotating computer/keyboard hero animation with "hello world" on screen
- Any other fancy animations or visual flourishes
- Further exploration of the color theme (current purple/violet accent is not final —
  she's not fully happy with it, but this is parked until after MVP ships)

## Technical / Design Details
- Stack: PHP/MySQL backend (dynamic, admin-editable), dark theme with accent color
  (currently purple/violet — open to revisiting post-launch)
- Local dev: XAMPP, Apache + MySQL on port 3307, MySQL root password `1234`
- Hosting target once satisfied: AwardSpace
- Contact email: okhelfaoui23@gmail.com — email link should open Gmail directly
  (app or web), pre-filled, for people to describe what they want built
- CTA button text: **"Let's Work"** (not "Hire Me")
- Links to include: GitHub (github.com/Omayma-lang), LinkedIn
  (linkedin.com/in/omayma-khelfaoui-a04657333), Instagram (instagram.com/tech_dev19)

## Definition of Done (launch checklist)
- [ ] All 4 core sections written and working (home, case study, about, contact)
- [ ] Contact form tested end-to-end, including the Gmail deep-link
- [ ] Case study has real screenshots, not placeholders
- [ ] Site tested and working on mobile
- [ ] Admin panel form tested (can add a project end-to-end)
- [ ] 1–2 people outside her own head review the site cold and can accurately describe
      what she does, before calling it launched

## Open Questions (not yet resolved)
- Exact hero/headline copy — not yet drafted
- Final color direction (purple/violet accent under reconsideration)
- Who the 1–2 outside reviewers will be

## Next Concrete Action
Draft the homepage/hero copy and the case-study structure first — copy was identified as
the biggest risk (vague copy is the most likely reason a visitor bounces), so get that
right before touching layout or the admin panel build.

## Risks to Watch
- Letting the color/theme exploration reopen scope before MVP ships
- Adding the 3D computer or other flourishes before the 4 core sections are complete
- Skipping the outside-reviewer step and shipping on gut feel alone
