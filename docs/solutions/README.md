# Documented Solutions

Past problems and their verified fixes. Each doc captures what went wrong, the root cause, the solution that fixed it, and how to prevent recurrence.

## How to use

Search `docs/solutions/` at these times:

- Before implementing a feature in a documented area — a past fix may inform the approach
- While debugging — the problem may have already been solved
- During code review — check whether a change violates documented patterns

Each learning has YAML frontmatter with `module`, `tags`, `date`, and `problem_type` for filtering.

## Directory organization

```
docs/solutions/
├── README.md              # This file
├── <topic>/               # Learnings grouped by domain (e.g., auth/, database/, campaigns/)
│   └── *.md               # Individual learning documents
└── patterns/              # Cross-cutting patterns derived from multiple learnings
    └── *.md
```

## Writing a new learning

Run `ce-compound` in Pi after solving a problem. The skill produces a doc with the right frontmatter and structure: problem statement, root cause, solution, and prevention.
