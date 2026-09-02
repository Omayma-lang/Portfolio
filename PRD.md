# Product Requirements Document — Freelance Portfolio Website

**Owner:** Omayma
**Status:** Draft
**Target launch:** ~3 weeks from kickoff

---

## 1. Overview

A dynamic (PHP/MySQL) personal portfolio website whose job is to convert visiting small
business / individual clients into freelance hires — primarily for web development, with
UI/UX design and video editing positioned as complementary skills.

## 2. Problem Statement

Right now there is no live, dedicated site that presents Omayma's freelance work
credibly to a stranger landing on it cold. Freelance platform profiles (e.g. Mostaqil)
don't give enough room to prove skill or build trust. A portfolio site is needed to close
that gap and become the link she can point clients to.

## 3. Goals

| Goal | Success looks like |
|---|---|
| Convert visitors into leads | Visitor understands what she builds and contacts her via the form |
| Establish credibility with one project | The single case study reads as competent and complete, not thin |
| Support future growth | New projects/certificates can be added without a rebuild |
| Ship on time | Live within ~3 weeks, not stuck in open-ended polish |

## 4. Target Audience

**Primary:** Small business or individual clients who would hire a freelancer for web
development, UI/UX design, or video editing work — the kind of person who would find her
through Mostaqil or a shared link.

**Explicitly not optimized for:** recruiters/employers, general portfolio browsers,
Instagram followers. If they visit, fine — but no section should be designed for them at
the expense of the primary audience.

## 5. Positioning & Messaging

- Lead offer: **web development**. UI/UX and video editing are framed as complementary
  skills, not separate businesses — do not pitch all three with equal weight.
- Copy must name a specific kind of client/project (e.g. "ordering/booking sites for
  small local businesses") rather than generic language like "full-stack developer" or
  "I build websites."
- Do not describe her as a student.
- Do not list specific programming languages/frameworks by name in the intro copy.
- CTA button label: **"Let's Work"** (not "Hire Me").

## 6. Scope

### 6.1 In Scope (MVP — required for launch)

| # | Feature | Notes |
|---|---|---|
| 1 | Home / Hero section | Headline + specific positioning copy, CTA to contact |
| 2 | Case study: Bookstore project | Deep format — problem, decisions, screenshots, tech used, what she'd improve. Not a one-line card |
| 3 | About / Skills section | No "student" framing, no language list |
| 4 | Contact section | Gmail deep-link (pre-filled, opens app or web) to okhelfaoui23@gmail.com |
| 5 | Admin panel (basic) | Simple form to add new projects/certificates later. Not a dashboard |
| 6 | Social/profile links | GitHub, LinkedIn, Instagram |

### 6.2 Out of Scope for MVP (deferred to post-launch)

- 3D rotating computer/keyboard hero animation ("hello world" on screen)
- Any additional animations or visual flourishes
- Further exploration/finalization of accent color (current purple/violet not considered
  final, but not a launch blocker)
- Additional project case studies (added later via admin panel as they're finished)
- Empty "coming soon" placeholders for future projects — explicitly excluded, as they
  signal inactivity rather than progress

## 7. Functional Requirements

1. Site must run on a PHP/MySQL backend so content is editable without redeploying code.
2. Admin panel must allow adding a new project (title, description, images, tech,
   link) and have it appear on the public site without a manual code change.
3. Contact form / email link must open Gmail (app or web) with the recipient address
   pre-filled, ready for the visitor to write their message.
4. Site must be responsive and function correctly on mobile.
5. Dark theme with a defined accent color (currently purple/violet, subject to revision).

## 8. Non-Functional Requirements

- Reasonable load time on shared hosting (target: AwardSpace).
- Should look credible/professional on first glance — no placeholder text or lorem ipsum
  at launch.

## 9. Technical Notes

- Local environment: XAMPP, Apache + MySQL on port 3307.
- Hosting target once complete: AwardSpace.
- Existing proof-of-work: bookstore e-commerce site
  (okhelfaoui23.atwebpages.com/main.html).

## 10. Definition of Done / Launch Checklist

- [ ] Home, case study, about, and contact sections written and functioning
- [ ] Contact form/Gmail deep-link tested end-to-end
- [ ] Case study includes real screenshots (no placeholders)
- [ ] Site verified on mobile
- [ ] Admin panel tested — can add a project end-to-end and see it appear live
- [ ] 1–2 people outside her own perspective review the site cold and can correctly
      describe what she offers, before it's called launched

## 11. Open Questions

- Exact hero/headline copy — not yet drafted
- Final accent color / theme direction
- Who the 1–2 outside reviewers will be

## 12. Risks

| Risk | Mitigation |
|---|---|
| Only one project at launch looks thin | Present it as a deep case study, not a card |
| Color/theme exploration reopens scope | Explicitly deferred to post-MVP |
| 3D computer/animation work delays launch | Explicitly deferred to post-MVP |
| Vague copy fails to convert visitors | Copy must name specific client/project type |
| Shipping on gut feel without real validation | Outside-reviewer step required before launch |

## 13. Next Step

Draft the homepage/hero copy and case-study structure first — copy was identified as the
highest-risk area, so resolve it before layout or admin-panel implementation begins.
