# Task 19: Git Operations Demonstration

This task demonstrates the fundamental Git workflow used to manage version history and collaborate on projects.

## Core Git Operations

1.  **Initializing a Repository**: 
    Setting up a new Git project.
    ```bash
    git init
    ```

2.  **Staging Files**:
    Preparing files for a commit by adding them to the staging area.
    ```bash
    git add sample.txt
    # Or to add all files:
    git add .
    ```

3.  **Committing Changes**:
    Recording the staged changes into the version history with a descriptive message.
    ```bash
    git commit -m "Initial commit: Add sample.txt and documentation"
    ```

4.  **Maintaining Version History**:
    Viewing the history of commits to track progress and changes over time.
    ```bash
    git log --oneline
    ```

5.  **Managing Remote Repositories**:
    Connecting the local repository to a remote server (like GitHub) and pushing changes.
    ```bash
    git remote add origin https://github.com/Akhil25412/full-stack-slotE1-.git
    git push -u origin main
    ```

## Demonstration Summary
In this task, I created a sample project directory (`task19`), added a `sample.txt` file, and documented the process of tracking its versions. These operations ensure that code changes are safely recorded and can be shared with other developers through remote repositories.
