# CLAUDE.md

## Project

This is a Laravel 10 application for an online art shop.

The project is an existing production application and changes should be made conservatively. Prefer improving existing code over introducing new architecture.

---

## Tech Stack

- Laravel 10
- PHP 8.3
- Blade
- MySQL/MariaDB
- Docker (Laravel Sail)
- Vanilla JavaScript and jQuery
- Bootstrap

---

## General Guidelines

- Follow existing coding style.
- Keep changes as small as possible.
- Prefer consistency with the existing codebase over introducing new patterns.
- Avoid unnecessary refactoring.
- Do not rename files, classes or methods unless explicitly requested.
- Do not introduce additional dependencies without approval.
- Do not use git for any commits. I'll do this manually.

---

## Laravel Guidelines

Use Laravel conventions whenever possible.

- Use Eloquent relationships instead of manual joins when appropriate.
- Use Form Requests for validation when validation becomes non-trivial.
- Prefer Collections over manual array manipulation.
- Use dependency injection.
- Use route model binding where already used.
- Use Cache facade only where caching already exists or where requested.
- Keep controllers thin.
- Business logic belongs in Services or existing domain classes.
- Do not duplicate existing functionality.

---

## Database

- Never modify migrations unless explicitly requested.
- Never delete existing columns.
- Preserve backwards compatibility.
- Ask before making destructive schema changes.

---

## Blade

- Reuse existing Blade components and layouts.
- Keep templates readable.
- Avoid embedding large amounts of PHP inside Blade.
- Do not change UI unnecessarily.

---

## JavaScript

- Prefer existing JavaScript style.
- Avoid introducing frameworks.
- Keep scripts simple.

---

## Performance

- Avoid N+1 queries.
- Use eager loading where appropriate.
- Do not prematurely optimize.
- Preserve existing caching strategy.

---

## Security

Always consider:

- authorization
- validation
- XSS
- CSRF
- SQL injection

Do not expose sensitive information.

---

## Before Making Changes

First understand:

- how the current implementation works
- whether similar functionality already exists
- whether existing helpers or services can be reused

Prefer extending existing code over rewriting it.

---

## When Unsure

If requirements are ambiguous:

- explain assumptions
- ask questions before implementing large changes

---

## Code Quality

When writing code:

- keep methods small
- avoid duplication
- write self-explanatory code
- avoid clever solutions
- prefer readability

---

## Refactoring Policy

Assume this project is already in production.

Do not:

- rewrite working code
- replace existing patterns with newer ones
- modernize code unless requested
- optimize code without evidence

Prefer:

- minimal diffs
- incremental improvements
- compatibility with the surrounding code

---

## Testing

If changing business logic:

- suggest appropriate tests
- do not invent tests that don't fit the existing project

---

## Output

Unless requested otherwise:

- provide complete code
- mention any files that need modification
- explain non-obvious decisions briefly
