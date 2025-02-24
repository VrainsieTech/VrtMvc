# Upgrading VrtMVC

## Overview
This guide explains how to upgrade VrtMVC to the latest version while ensuring compatibility with your existing projects.
But waaaaait, waaait, wait! Let me tell you something. You might break your project if you don't read the whole guide. So please read, because, one person used the framework as a dependency in `vendor/` while another used directly as a building block, so only use the process that upgrade the framework without interferring with your work.

## Checking Current Version
Run the following command to check the installed version:
```bash
composer show vrainsietech/vrtmvc
```

## Upgrading via Composer
To update VrtMVC to the latest stable release, run:
```bash
composer update vrainsietech/vrtmvc
```
If you want to upgrade to a specific version, specify it like this:
```bash
composer require vrainsietech/vrtmvc:^1.2.0
```

## Handling Breaking Changes
Review the changelog [Change Log](`changelog.md`) for any breaking changes and necessary modifications.

### Configuration Updates
If new configurations are introduced, merge them manually:
1. Compare your `config/` files with the new version.
2. Update missing configurations while preserving custom settings.

### Database Migrations
If the upgrade includes database changes, apply migrations:
```bash
./vrtcli migrate
```

### Clearing Cache
After upgrading, clear caches to prevent conflicts:
```bash
./vrtcli cache:clear
```

## Upgrading When Using `composer create-project`
If you installed VrtMVC using `composer create-project`, the framework is part of your project’s core files. In this case, do not use `composer require vrainsietech/vrtmvc`, as it will install the framework as a dependency in `vendor/` and cause conflicts.

### Recommended Upgrade Process:
1. **Check for Updates**  
   Run:
   ```bash
   composer update vrainsietech/vrtmvc
   ```
   If the framework is listed as a dependency, this will update it.

2. **Manually Pull Changes**  
   If VrtMVC is not a dependency, pull the latest version from the repository and merge updates:
   ```bash
   git pull origin main
   ```
   Then, review changes and merge them carefully to avoid overwriting custom modifications.

3. **Compare Changes with a Diff Tool**  
   Since project files have likely been modified, using a diff tool like `git diff` or `meld` can help compare old and new framework files before merging.

4. **Run Migrations & Clear Cache**  
   After updating, execute:
   ```bash
   ./vrtcli migrate
   ./vrtcli cache:clear
   ```

### Best Practices for Avoiding Future Upgrade Issues
- Use a **customized `src/` folder** for application logic while keeping framework updates separate.
- Maintain **version control (Git)** to track changes.
- Avoid modifying core framework files unless necessary.

## Testing After Upgrade
1. Run tests to ensure everything functions correctly:
```bash
./vrtcli test
```
2. Manually verify application functionality.

## Rolling Back an Upgrade
If an issue occurs, revert to the previous version:
```bash
composer require vrainsietech/vrtmvc:^previous-version
```

## Summary
- Use Composer to upgrade VrtMVC.
- Check changelog for breaking changes.
- Update configurations and run migrations if necessary.
- Clear cache and test functionality after upgrade.
- Rollback if needed using Composer.
- If using `composer create-project`, upgrade manually to avoid conflicts.

For any issues, visit the [GitHub repository](https://github.com/vrainsietech/vrtmvc) or contact support.

