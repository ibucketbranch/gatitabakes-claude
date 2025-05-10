# PROJECT RULES for Gatita Bakes Online Order Form

## 1. File Headers
- Every file in the project must have a header at the top in the following format:
```
/**
 * Project: Gatita Bakes Online Order System (Same for all files of this project)
 * Title: "[e.g. if file is called Order-form.php then the Title = Name of file, in this example, it would be Order Form. ]"
 * Author/Developer: Bucketbranch Engineering LLC
 * Version: 20250905.1
 * Date: [YYYY-MM-DD]
 */
```
- The Title should be file-name. see above
- The Project line is always: `Gatita Bakes Online Order System`.

## 2. Always Check-in every 59 mins, Commit all changes to all files, sacan all files for changes and Push to repo, and last Verify the commit and push was successful
- All code changes must be committed and pushed to the GitHub repo for this project. https://github.com/ibucketbranch/gatitabakes-claude
- After every commit/push, provide an immediate report of what changed (files, lines, summary, and terminal output).

## 3. Auto-Run Commands
- Auto-run commands in the cursor IDE and where possible, unless restricted by operating system or security boundaries.
- If approval is required, batch changes for single approval when possible.

## 4. User Authority
- The user (project owner) is always in charge. Their instructions override defaults.

## 5. Rule Addition
- Add new rules as the user thinks of them, and update this file accordingly. Trigger this rule when you see "New Rule: "

## 6. Rule Suggestions
- Proactively suggest rules or best practices to keep the workflow efficient and in tune with user expectations.

## 7. Daily Branching
- Before starting a new day of coding, create a new branch named `<YYYYMMDD.x>` (e.g., `20250509.1`).
- If branching more than once in a day, increment the `.x` (e.g., `20250509.2`).

## 8. UI Mockups and Design Consistency
- When the user requests changes to UI or flow, always refer to the UI folder with mockups (`/Users/michaelvalderrama/Websites/Claude/UI`).
- Code must reflect the look, feel, and style of the mockups in this folder.
- If the code does not match the mockup, continue iterating until it does, following the principles and design shown in the mockups.

## 9. Timestamp Monitoring and Automatic Commits
- Check file timestamps regularly; if more than 59 minutes have passed since the last check-in, commit any files that have changed.
- Include all modified files in the commit regardless of whether they were explicitly modified during the current session.
- Follow standard commit procedures outlined in Rule #2 for these automatic commits.

---

**This file is the source of truth for all project rules. All actions, edits, and decisions must reference and comply with these rules.** 