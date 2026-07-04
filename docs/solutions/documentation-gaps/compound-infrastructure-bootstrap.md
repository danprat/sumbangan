---
title: Bootstrapping Compound Engineering Infrastructure
date: 2026-07-04
category: documentation-gaps
module: documentation
problem_type: documentation_gap
component: documentation
severity: medium
root_cause: incomplete_setup
resolution_type: documentation_update
applies_when:
  - setting up a new agent-assisted Laravel project
  - retrofitting an existing project with institutional knowledge infrastructure
tags: [compound-infrastructure, documentation, bootstrapping, agents, knowledge-base]
related_components:
  - development_workflow
---

# Bootstrapping Compound Infrastructure for Agent-Assisted Laravel Projects

## Context

The Sumbangan platform started as a fresh Laravel 13 skeleton and grew across six incremental feature commits: models and factories (U1), admin authentication with session guard (U2), bank account CRUD (U3), campaign CRUD with image upload and slug generation (U4), donation verification with status filtering (U5), and public pages with progress tracking (U6). Each feature built on the one before it, and by U6 the domain vocabulary (Campaign, Donation, Bank Account, Admin, verification lifecycle, token tracking, proof-of-transfer images) was well-established but existed only in code — not in any discoverable form an agent could ground on.

Without institutional knowledge infrastructure, every session starts cold. Agents re-derive the meaning of "verified donation" from database columns, reinvent naming conventions, or miss that the project already has documented patterns. This is the gap: a Laravel project with six features and zero shared knowledge artifacts, where only the developer's memory distinguishes a convention from an accident.

## Guidance

Three concrete artifacts bootstrap a compound knowledge system. Each is small enough to create in one commit and durable enough to survive feature churn.

### 1. CONCEPTS.md — shared domain vocabulary

A glossary at the repo root defining project-specific terms. Not a spec, not a catch-all — just the nouns, processes, and status concepts a new engineer (or agent) needs defined to follow code, tickets, and conversations.

For Sumbangan, the file clusters entries by domain:

- **Campaign cluster** — Campaign, Campaign Progress, Remaining Days
- **Donation cluster** — Donation, Donation Status (with pending→verified/rejected lifecycle), Token (UUID tracking), Verification, Proof of Transfer
- **Admin cluster** — Bank Account, Admin

Each entry is one sentence defining what the term means in this domain, followed by behavioral rules when non-obvious (lifecycle transitions, ownership invariants, display rules). Retired synonyms get an *Avoid* alias line. The file closes with a "Flagged ambiguities" tail that records resolved terminology debates — e.g., the distinction between donation lifecycle status and campaign completion state.

The preamble establishes the file's role: "Seeded with core domain vocabulary, then accretes as ce-compound and ce-compound-refresh process learnings; direct edits are fine."

**Before:** An agent sees `$donation->status === 'verified'` and guesses it means "completed" or "paid." It might use `verified` and `confirmed` interchangeably, or treat `rejected` donations as deletable.

**After:** The agent reads CONCEPTS.md and knows: verified means an admin reviewed the proof-of-transfer and accepted it, the `verified_at` timestamp is the canonical audit trail, only verified donations count toward campaign progress, and rejected donations carry mandatory admin notes.

### 2. docs/solutions/ — documented solutions directory

A directory with a README that tells agents **when** to search, **how** to search (YAML frontmatter with `module`, `tags`, `problem_type`), and **what** they'll find. The `patterns/` subdirectory holds cross-cutting patterns derived from multiple learnings.

The README serves as the entry point. It frames the store as organic — populated by `ce-compound` after solving problems — rather than a static reference. This framing matters: it signals to agents that the store is active, not dead documentation.

### 3. Instruction file discoverability

Without surfacing these artifacts in the project's instruction files, they're invisible to agents. The AGENTS.md edit adds two bullet points to the existing "Documentation Files" section:

```markdown
## Documentation Files

- You must only create documentation files if explicitly requested by the user.
- `docs/solutions/` — documented fixes to past problems (bugs, best practices, workflow patterns), organized by topic with YAML frontmatter (`module`, `tags`, `problem_type`). Relevant when implementing or debugging in documented areas.
- `CONCEPTS.md` — shared domain vocabulary for the project. Read when orienting to the codebase or before discussing domain concepts.
```

The existing section already discussed documentation creation policy, so these lines extend it rather than introduce a new heading. The tone describes what exists and when it's relevant — it does not command agents to check before every action, trusting their judgment about when a search is warranted.

## Why This Matters

Knowledge compounds only when it's discoverable. The first time someone (or an agent) debugs a donation status lifecycle issue, it takes research — reading models, migrations, controllers, and tests to understand the `pending → verified/rejected` flow. With CONCEPTS.md, that orientation happens in seconds. With docs/solutions/, the actual debugging is documented once and reused. The cost of retrofitting this later grows with every new feature — it's cheaper to bootstrap now while the domain is still six features than to reconstruct it at twenty.

For agent-assisted development specifically, these artifacts replace the context that human teammates pick up through code review and conversation. An agent that reads CONCEPTS.md before writing a donation feature will not invent a "confirmed" status or store verification state in a boolean column — it knows the vocabulary.

## When to Apply

- Starting a new agent-assisted Laravel project — bootstrap CONCEPTS.md and `docs/solutions/` when the first domain nouns stabilize (3–5 models, 2+ feature areas)
- Retrofitting an existing project that has grown beyond what one person holds in memory — seed CONCEPTS.md from the declared domain model, add the discoverability lines to AGENTS.md, then run `ce-compound` to capture the first learning
- Before the feature surface grows beyond 8–10 commits, after which reconstructing vocabulary from code alone becomes a research exercise

## Examples

**Before CONCEPTS.md:** An agent working on a new donation tracking feature invents the term "donation ticket" and stores state as a boolean `is_approved`. It doesn't know the project already uses "token" and a three-state lifecycle.

**After CONCEPTS.md:** The same agent reads the Donation Status entry, understands pending/verified/rejected, knows tokens are UUID v4, and writes code consistent with the existing model.

The CONCEPTS.md structure itself is an example worth replicating: a preamble explaining accretion, domain-aligned clusters, one-sentence definitions with behavioral rules where needed, aliases for retired terms, and a flagged ambiguities tail that grows over time.

## Related

- `ce-compound` — the skill that captures solved problems into `docs/solutions/` and maintains CONCEPTS.md as a side effect of each learning
- `ce-compound-refresh` — scans `docs/solutions/` for stale or outdated learnings after refactors, migrations, or dependency upgrades
